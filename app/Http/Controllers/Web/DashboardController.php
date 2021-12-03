<?php

namespace App\Http\Controllers\Web;

use App\Helpers\FunctionHelper;
use App\Http\Controllers\Controller;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.index');
    }

    public function chart1(Request $request)
    {
        // if (!Cache::has("chart1.t=$request->t.d=$request->d")) {
            $date = Carbon::createFromFormat('Y-m-d', $request->d);
            $data = Log::when($request->t === 'd', function ($query) use ($request, $date) {
                           return $query->whereDate('CreateDate', $date->toDateString());
                       })
                       ->when($request->t === 'M', function ($query) use ($request, $date) {
                           return $query->whereMonth('CreateDate', $date->month)
                                       ->whereYear('CreateDate', $date->year);
                       })
                       ->when($request->t === 'y', function ($query) use ($request, $date) {
                           return $query->whereYear('CreateDate', $date->year);
                       })
                       ->when(!empty($request->mrc), function ($query) use ($request) {
                           return auth()->user()->is_admin ?
                                  $query->where('IdMerchant', $request->mrc) :
                                  $query;
                       })
                       ->when(!auth()->user()->is_admin, function ($query) use ($request) {
                           return $query->where('IdMerchant', auth()->user()->merchant->Id);
                       })
                       ->get();

            $inLogs = $data->where('Status', 200)
                           ->where('Point', '>=', 0)
                           ->groupBy(function ($query) use ($request){
                               if ($request->t === 'd') {
                                   return $query->CreateDate->format('H:00');
                               }
                               elseif ($request->t === 'M') {
                                   return $query->CreateDate->format('d-m-Y');
                               }
                               elseif ($request->t === 'y') {
                                   return $query->CreateDate->monthName;
                               }
                           });
            $this->formatChartData($request->t, $request->d, $inLogs);

            $outLogs = $data->where('Status', 200)
                            ->where('Point', '<', 0)
                            ->groupBy(function ($query) use ($request){
                                if ($request->t === 'd') {
                                    return $query->CreateDate->format('H:00');
                                }
                                elseif ($request->t === 'M') {
                                    return $query->CreateDate->format('d-m-Y');
                                }
                                elseif ($request->t === 'y') {
                                    return $query->CreateDate->monthName;
                                }
                            });
            $this->formatChartData($request->t, $request->d, $outLogs);
            $merged = $this->mergeDataChart(compact('inLogs', 'outLogs'));
            Cache::put("chart1.t=$request->t.d=$request->d", $merged, now()->addMinutes(30));
        // }
        $merged = Cache::get("chart1.t=$request->t.d=$request->d");
        return response()->json($merged);
    }

    public function chart1Stat(Request $request)
    {
        // if (!Cache::has("chart1stat.t=$request->t.d=$request->d") || $request->has('isDebug')) {
            $date = Carbon::createFromFormat('Y-m-d', $request->d);

            if ($request->t === 'd') {
                $dateOld = Carbon::createFromFormat('Y-m-d', $request->d)
                                  ->subDay();
            }
            elseif ($request->t === 'M') {
                $dateOld = Carbon::createFromFormat('Y-m-d', $request->d)
                                  ->subMonth();
            }
            elseif ($request->t === 'y') {
                $dateOld = Carbon::createFromFormat('Y-m-d', $request->d)
                                  ->subYear();
            }

            $data = Log::when($request->t === 'd', function ($query) use ($request, $date, $dateOld) {
                              return $query->whereDate('CreateDate', '>=', $dateOld->toDateString())
                                           ->whereDate('CreateDate', '<', $date->addDay()->toDateString());
                         })
                         ->when($request->t === 'M', function ($query) use ($request, $date, $dateOld) {
                              return $query->whereDate('CreateDate', '>=', $dateOld->day(1)->toDateString())
                                           ->whereDate('CreateDate', '<', $date->addMonth()->day(1)->toDateString());
                         })
                         ->when($request->t === 'y', function ($query) use ($request, $date, $dateOld) {
                             return $query->whereYear('CreateDate', '>=', $dateOld->year)
                                          ->whereYear('CreateDate', '<', $date->addYear()->year);
                         })
                         ->when(!empty($request->mrc), function ($query) use ($request) {
                             return auth()->user()->is_admin ?
                                    $query->where('IdMerchant', $request->mrc) :
                                    $query;
                         })
                         ->when(!auth()->user()->is_admin, function ($query) use ($request) {
                             return $query->where('IdMerchant', auth()->user()->merchant->Id);
                         })
                         ->get();
            // dd($data->toSql(), $data->getBindings());

            if ($request->t === 'd') {
                $success = $data->filter(function ($item, $key) use ($request) {
                    $date = Carbon::createFromFormat('Y-m-d', $request->d);
                    return $item->CreateDate->between(
                        $date->setTime(0, 0)->toDateTimeString(),
                        $date->setTime(23, 59, 59)->toDateTimeString()
                    );
                })->where('Status', 200)->count();

                $failed = $data->filter(function ($item, $key) use ($request) {
                    $date = Carbon::createFromFormat('Y-m-d', $request->d);
                    return $item->CreateDate->between(
                        $date->setTime(0, 0)->toDateTimeString(),
                        $date->setTime(23, 59, 59)->toDateTimeString()
                    );
                })->where('Status', '!=', 200)->count();

                $successOld = $data->filter(function ($item, $key) use ($request) {
                    $dateOld = Carbon::createFromFormat('Y-m-d', $request->d)->subDay();
                    return $item->CreateDate->between(
                        $dateOld->setTime(0, 0)->toDateTimeString(),
                        $dateOld->setTime(23, 59, 59)->toDateTimeString()
                    );
                })->where('Status', 200)->count();

                $failedOld = $data->filter(function ($item, $key) use ($request) {
                    $dateOld = Carbon::createFromFormat('Y-m-d', $request->d)->subDay();
                    return $item->CreateDate->between(
                        $dateOld->setTime(0, 0)->toDateTimeString(),
                        $dateOld->setTime(23, 59, 59)->toDateTimeString()
                    );
                })->where('Status', '!=', 200)->count();

                $successPercent = $successOld == 0 ? '-' : floor((abs($successOld - $success) / $successOld) * 100) . "%";
                $failedPercent = $failedOld == 0 ? '-' : floor((abs($failedOld - $failed) / $failedOld) * 100) . "%";
                $success = FunctionHelper::thousandsCurrencyFormat($success);
                $failed = FunctionHelper::thousandsCurrencyFormat($failed);
            }
            elseif ($request->t === 'M') {
                $success = $data->filter(function ($item, $key) use ($request) {
                    $date = Carbon::createFromFormat('Y-m-d', $request->d);
                    return $item->CreateDate->between(
                        $date->day(1)->setTime(0, 0)->toDateTimeString(),
                        $date->day($date->daysInMonth)->setTime(23, 59, 59)->toDateTimeString()
                    );
                })->where('Status', 200)->count();

                $failed = $data->filter(function ($item, $key) use ($request) {
                    $date = Carbon::createFromFormat('Y-m-d', $request->d);
                    return $item->CreateDate->between(
                        $date->day(1)->setTime(0, 0)->toDateTimeString(),
                        $date->day($date->daysInMonth)->setTime(23, 59, 59)->toDateTimeString()
                    );
                })->where('Status', '!=', 200)->count();

                $successOld = $data->filter(function ($item, $key) use ($request) {
                    $dateOld = Carbon::createFromFormat('Y-m-d', $request->d)->subMonth();
                    return $item->CreateDate->between(
                        $dateOld->day(1)->setTime(0, 0)->toDateTimeString(),
                        $dateOld->day($dateOld->daysInMonth)->setTime(23, 59, 59)->toDateTimeString()
                    );
                })->where('Status', 200)->count();

                $failedOld = $data->filter(function ($item, $key) use ($request) {
                    $dateOld = Carbon::createFromFormat('Y-m-d', $request->d)->subMonth();
                    return $item->CreateDate->between(
                        $dateOld->day(1)->setTime(0, 0)->toDateTimeString(),
                        $dateOld->day($dateOld->daysInMonth)->setTime(23, 59, 59)->toDateTimeString()
                    );
                })->where('Status', '!=', 200)->count();

                $successPercent = $successOld == 0 ? '-' : floor((abs($successOld - $success) / $successOld) * 100) . "%";
                $failedPercent = $failedOld == 0 ? '-' : floor((abs($failedOld - $failed) / $failedOld) * 100) . "%";
                $success = FunctionHelper::thousandsCurrencyFormat($success);
                $failed = FunctionHelper::thousandsCurrencyFormat($failed);
            }
            elseif ($request->t === 'y') {
                $success = $data->filter(function ($item, $key) use ($request) {
                    $date = Carbon::createFromFormat('Y-m-d', $request->d);
                    return $item->CreateDate->between(
                        Carbon::create($date->year, 1, 1, 0, 0, 0),
                        Carbon::create($date->year, 12, 31, 23, 59, 59)
                    );
                })->where('Status', 200)->count();

                $failed = $data->filter(function ($item, $key) use ($request) {
                    $date = Carbon::createFromFormat('Y-m-d', $request->d);
                    return $item->CreateDate->between(
                        Carbon::create($date->year, 1, 1, 0, 0, 0),
                        Carbon::create($date->year, 12, 31, 23, 59, 59)
                    );
                })->where('Status', '!=', 200)->count();

                $successOld = $data->filter(function ($item, $key) use ($request) {
                    $dateOld = Carbon::createFromFormat('Y-m-d', $request->d)->subYear();
                    return $item->CreateDate->between(
                        Carbon::create($dateOld->year, 1, 1, 0, 0, 0),
                        Carbon::create($dateOld->year, 12, 31, 23, 59, 59)
                    );
                })->where('Status', 200)->count();

                $failedOld = $data->filter(function ($item, $key) use ($request) {
                    $dateOld = Carbon::createFromFormat('Y-m-d', $request->d)->subYear();
                    return $item->CreateDate->between(
                        Carbon::create($dateOld->year, 1, 1, 0, 0, 0),
                        Carbon::create($dateOld->year, 12, 31, 23, 59, 59)
                    );
                })->where('Status', '!=', 200)->count();

                $successPercent = $successOld == 0 ? '-' : floor((abs($successOld - $success) / $successOld) * 100) . "%";
                $failedPercent = $failedOld == 0 ? '-' : floor((abs($failedOld - $failed) / $failedOld) * 100) . "%";
                $success = FunctionHelper::thousandsCurrencyFormat($success);
                $failed = FunctionHelper::thousandsCurrencyFormat($failed);
            }

            Cache::put("chart1stat.t=$request->t.d=$request->d", compact('success', 'successOld', 'successPercent', 'failed', 'failedOld', 'failedPercent'), now()->addMinutes(30));
        // }
        $result = Cache::get("chart1stat.t=$request->t.d=$request->d");
        return response()->json($result);
    }

    public function chart2(Request $request)
    {
        // dd($request->mrc);
        $date = Carbon::createFromFormat('Y-m-d', $request->d);
        $data = Log::when($request->t === 'd', function ($query) use ($request, $date) {
                        return $query->whereDate('Log.CreateDate', $date->toDateString());
                   })
                   ->when($request->t === 'M', function ($query) use ($request, $date) {
                        return $query->whereMonth('Log.CreateDate', $date->month)
                                       ->whereYear('Log.CreateDate', $date->year);
                   })
                   ->when($request->t === 'y', function ($query) use ($request, $date) {
                        return $query->whereYear('Log.CreateDate', $date->year);
                   })
                   ->when(!empty($request->mrc), function ($query) use ($request) {
                       return auth()->user()->is_admin ?
                           $query->where('IdMerchant', $request->mrc) :
                           $query;
                   })
                   ->when(!auth()->user()->is_admin, function ($query) use ($request) {
                       return $query->where('IdMerchant', auth()->user()->merchant->Id);
                   })
                   ->select(DB::raw("Log.IdMember, Member.Nama, COUNT(Log.Id) as 'Hit', SUM(Log.Point) as 'Point'"))
                   ->join('Member', 'Log.IdMember', '=', 'Member.Id')
                   ->groupBy(['Log.IdMember', 'Member.Nama'])
                   ->orderBy($request->of1, $request->ot1)
                   ->when($request->has('of2'), function ($query) use ($request) {
                       return $query->orderBy($request->of2, $request->ot2);
                   })
                   ->limit(10)
                   ->get();
        return response()->json($data);
    }

    public function chart3(Request $request)
    {
        $date = Carbon::createFromFormat('Y-m-d', $request->d);
        $data = Log::when($request->t === 'd', function ($query) use ($request, $date) {
                       return $query->whereDate('CreateDate', $date->toDateString());
                   })
                   ->when($request->t === 'M', function ($query) use ($request, $date) {
                       return $query->whereMonth('CreateDate', $date->month)
                                   ->whereYear('CreateDate', $date->year);
                   })
                   ->when($request->t === 'y', function ($query) use ($request, $date) {
                       return $query->whereYear('CreateDate', $date->year);
                   })
                   ->when(!empty($request->mrc), function ($query) use ($request) {
                       return auth()->user()->is_admin ?
                           $query->where('IdMerchant', $request->mrc) :
                           $query;
                   })
                   ->when(!auth()->user()->is_admin, function ($query) use ($request) {
                       return $query->where('IdMerchant', auth()->user()->merchant->Id);
                   })
                   ->get();
        $success = $data->where('Status', 200)
                        ->groupBy(function ($query) use ($request) {
                            if ($request->t === 'd') {
                                return $query->CreateDate->format('H:00');
                            }
                            elseif ($request->t === 'M') {
                                return $query->CreateDate->format('d-m-Y');
                            }
                            elseif ($request->t === 'y') {
                                return $query->CreateDate->monthName;
                            }
                        });

        $failed = $data->where('Status', '!=', 200)
                       ->groupBy(function ($query) use ($request) {
                           if ($request->t === 'd') {
                               return $query->CreateDate->format('H:00');
                           }
                           elseif ($request->t === 'M') {
                               return $query->CreateDate->format('d-m-Y');
                           }
                           elseif ($request->t === 'y') {
                               return $query->CreateDate->monthName;
                           }
                       });

        $this->formatChartData($request->t, $request->d, $success, false);
        $this->formatChartData($request->t, $request->d, $failed, false);
        $merged = $this->mergeDataChart(compact('success', 'failed'));
        return response()->json($merged);
    }

    private function formatChartData($t, $d, &$collection, $isSum = true)
    {
        $date = Carbon::createFromFormat('Y-m-d', $d);
        if ($t === 'd') {
            $loop = 24;
        }
        elseif ($t === 'M') {
            $loop = $date->daysInMonth;
        }
        elseif ($t === 'y') {
            $loop = 12;
        }

        for ($i = 0; $i < $loop; $i++) {
            if ($t === 'd') {
                $strToCheck = Str::padLeft($i, 2, '0') . ":00";
            }
            elseif ($t === 'M') {
                $strToCheck = now()->day($i+1)->month($date->month)->format('d-m-Y');
            }
            elseif ($t === 'y') {
                $strToCheck = now()->month($i+1)->monthName;
            }

            if ($collection->keys()->contains($strToCheck)) {
                if ($isSum) {
                    $collection[$strToCheck] = $collection[$strToCheck]->sum('Point');
                }
                else {
                    $collection[$strToCheck] = $collection[$strToCheck]->count();
                }
            }
            else {
                $collection->put($strToCheck, 0);
            }
        }
        $collection = $collection->sortKeys();
        $collection = $collection->map(function ($value, $key) {
            return [
                'date' => $key,
                'value' => $value
            ];
        })->values();
        if ($t === 'y') {
            $this->sortMonth($collection);
        }
    }

    private function sortMonth(&$collection)
    {
        $sorted = [];
        for ($i = 0; $i < $collection->count(); $i++) {
            $index = Carbon::createFromFormat('F', $collection[$i]['date'])->month;
            $sorted[$index-1] = $collection[$i];
        }
        $collection = collect($sorted)->sortKeys();
    }

    private function mergeDataChart(array $collections)
    {
        $result = array();
        foreach ($collections as $key => $collection) {
            $i = 0;
            foreach ($collection as $data) {
                if (!isset($result[$i]['date'])) {
                    $result[$i]['date'] = $data['date'];
                }
                $result[$i][$key] = $data['value'];
                $i++;
            }
        }
        return collect($result);
    }
}
