<?php

namespace App\Http\Controllers\Web;

use App\Helpers\FunctionHelper;
use App\Http\Controllers\Controller;
use App\Models\Log;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.index');
    }

    public function chart1(Request $request)
    {
        /**
         * Key cache
         */
        $mrc = ($request->has('mrc') || empty($request->mrc)) ? 0 : $request->mrc;
        $key = "chart1.t=$request->t.d=$request->d.mrc=$mrc";

        /**
         * Time to life of cache
         */
        $ttl = now()->addMinutes(30);

        /**
         * Caching data
         */
        $cached = Cache::tags('chart')->remember($key, $ttl, function () use ($request, $key, $ttl, $mrc) {

            /**
             * intance carbon datetime by $request->d from specific format.
             */
            $date = Carbon::createFromFormat('Y-m-d', $request->d);

            /**
             * Get log data with condition.
             * $request->t is "type". d is day, M is month, y is year
             */
            $data = Log::when($request->t === 'd', function ($query) use ($request, $date, $mrc) {
                        return $query->whereDate('CreateDate', $date->toDateString());
                    })
                    ->when($request->t === 'M', function ($query) use ($request, $date) {
                        return $query->whereMonth('CreateDate', $date->month)
                                    ->whereYear('CreateDate', $date->year);
                    })
                    ->when($request->t === 'y', function ($query) use ($request, $date) {
                        return $query->whereYear('CreateDate', $date->year);
                    })

                    /**
                        * $request->mrc is "merchant id"
                        * This condition will be executed when the user is admin
                        * Admin can select a specific merchant or leave it blank to get data from all merchants
                        */
                    ->when($mrc > 0, function ($query) use ($mrc) {
                        return auth()->user()->is_admin ?
                                $query->where('IdMerchant', $mrc) :
                                $query;
                    })

                    ->when(empty($request->mrc), function ($query) use ($request) {
                        return $query;
                    })

                    /**
                        * This condition will be executed when the user is not an admin
                        */
                    ->when(!auth()->user()->is_admin, function ($query) use ($request) {
                        return $query->where('IdMerchant', auth()->user()->merchant->Id);
                    })

                    /**
                        * Get only success transactions
                        */
                    ->where('Status', 200)
                    ->get();

            if ($request->t == 'd') {

                /**
                 * Make period like "00:00", "01:00", "02:00", "..."
                 */
                $period = CarbonPeriod::since($date->startOfDay()->toTimeString())
                                    ->hours(1)
                                    ->until($date->endOfDay()->toTimeString());

                /**
                 * Fill in the list of periods with logs at suitable times
                 */
                $result = collect($period->toArray())->map(function ($value, $key) use ($data) {

                    /**
                     * Retrieve log data with matching hour
                     */
                    $logs = $data->filter(function ($v, $k) use ($value) {
                        return $v->CreateDate->hour == $value->hour;
                    });

                    /**
                     * Retrieve log data with positive point attribute values
                     */
                    $logPlus = $logs->filter(function ($v, $k) {
                        return $v->Point >= 0;
                    });

                    /**
                     * Retrieve log data with negative point attribute values
                     */
                    $logMinus = $logs->filter(function ($v, $k) {
                        return $v->Point < 0;
                    });

                    /**
                     * Return data in array format
                     */
                    return [
                        'date' => $value->format('H:i'),
                        'plus' => $logPlus->sum('Point'),
                        'minus' => $logMinus->sum('Point'),
                    ];
                });
            }
            elseif ($request->t == 'M') {

                /**
                 * Make period like "2021-11-01", "2021-11-02", "2021-11-03", "..."
                 */
                $period = CarbonPeriod::create(
                    $date->startOfMonth()->toDateString(),
                    $date->endOfMonth()->toDateString()
                );

                /**
                 * Fill in the list of periods with logs at suitable date
                 */
                $result = collect($period->toArray())->map(function ($value, $key) use ($data) {

                    /**
                     * Retrieve log data with matching date
                     */
                    $logs = $data->filter(function ($v, $k) use ($value) {
                        return $v->CreateDate->toDateString() == $value->toDateString();
                    });

                    /**
                     * Retrieve log data with positive point attribute values
                     */
                    $logPlus = $logs->filter(function ($v, $k) {
                        return $v->Point >= 0;
                    });

                    /**
                     * Retrieve log data with negative point attribute values
                     */
                    $logMinus = $logs->filter(function ($v, $k) {
                        return $v->Point < 0;
                    });

                    /**
                     * Return data in array format
                     */
                    return [
                        'date' => $value->format('Y-m-d'),
                        'plus' => $logPlus->sum('Point'),
                        'minus' => $logMinus->sum('Point'),
                    ];
                });
            }
            elseif ($request->t == 'y') {

                /**
                 * Make period like "2021-01", "2021-02", "2021-03", "..."
                 */
                $period = CarbonPeriod::create(
                    $date->startOfYear()->toDateString(),
                    '1 month',
                    $date->endOfYear()->toDateString()
                );

                /**
                 * Fill in the list of periods with logs at suitable date
                 */
                $result = collect($period->toArray())->map(function ($value, $key) use ($data) {

                    /**
                     * Retrieve log data with matching month-year
                     */
                    $logs = $data->filter(function ($v, $k) use ($value) {
                        return $v->CreateDate->format('Y-m') == $value->format('Y-m');
                    });

                    /**
                     * Retrieve log data with positive point attribute values
                     */
                    $logPlus = $logs->filter(function ($v, $k) {
                        return $v->Point >= 0;
                    });

                    /**
                     * Retrieve log data with negative point attribute values
                     */
                    $logMinus = $logs->filter(function ($v, $k) {
                        return $v->Point < 0;
                    });

                    /**
                     * Return data in array format
                     */
                    return [
                        'date' => $value->format('M'),
                        'plus' => $logPlus->sum('Point'),
                        'minus' => $logMinus->sum('Point'),
                    ];
                });
            }

            return $result;
        });

        // return response()->json($result);
        return response()->json($cached);
    }

    public function chart1Stat(Request $request)
    {
        dd($this->chart1($request));
        $chart1 = collect($this->chart1($request)->getData(true));
        $plus = FunctionHelper::thousandsCurrencyFormat($chart1->sum('plus'));
        $minus = FunctionHelper::thousandsCurrencyFormat($chart1->sum('minus'));

        return response()->json(compact('plus', 'minus'));
    }

    public function chart2(Request $request)
    {
        $key = "chart2.t=$request->t.d=$request->d";
        $ttl = now()->addMinutes(30);
        $result = Cache::tags('chart')->remember($key, $ttl, function () use ($request, $key, $ttl) {
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
            Cache::tags('chart')->remember($key . ".lastUpdate", $ttl, function () {
                return now();
            });
            return $data;
        });

        return response()->json($result);
    }

    public function chart3(Request $request)
    {
        $key = "chart3.t=$request->t.d=$request->d";
        $ttl = now()->addMinutes(30);
        $result = Cache::tags('chart')->remember($key, $ttl, function () use ($request, $key, $ttl) {
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

            Cache::tags('chart')->remember($key . ".lastUpdate", $ttl, function () {
                return now();
            });
            return $merged;
        });
        return response()->json($result);
    }

    public function chartTime(Request $request)
    {
        return Cache::tags('chart')->get("$request->ch.t=$request->t.d=$request->d.lastUpdate", "Invalid Key!");
    }

    public function clearChartCache(Request $request)
    {
        Cache::tags('chart')->flush();
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
