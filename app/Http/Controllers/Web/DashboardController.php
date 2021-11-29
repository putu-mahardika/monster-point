<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.index');
    }

    public function chart1(Request $request)
    {
        $date = Carbon::createFromFormat('Y-m-d', $request->d);
        $inLogs = Log::when($request->t === 'd', function ($query) use ($request, $date) {
                          return $query->whereDate('CreateDate', $date->toDateString());
                     })
                     ->when($request->t === 'M', function ($query) use ($request, $date) {
                          return $query->whereMonth('CreateDate', $date->month)
                                       ->whereYear('CreateDate', $date->year);
                     })
                     ->when($request->t === 'y', function ($query) use ($request, $date) {
                         return $query->whereYear('CreateDate', $date->year);
                     })
                     ->where('Point', '>=', 0)
                     ->get()
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

        $outLogs = Log::when($request->t === 'd', function ($query) use ($request, $date) {
                          return $query->whereDate('CreateDate', $date->toDateString());
                      })
                      ->when($request->t === 'M', function ($query) use ($request, $date) {
                          return $query->whereMonth('CreateDate', $date->month)
                                       ->whereYear('CreateDate', $date->year);
                      })
                      ->when($request->t === 'y', function ($query) use ($request, $date) {
                          return $query->whereYear('CreateDate', $date->year);
                      })
                      ->where('Point', '<', 0)
                      ->get()
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
        // return response()->json(compact('inLogs', 'outLogs'));
        return response()->json($inLogs);
    }

    public function chart2(Request $request)
    {
        # code...
    }

    public function chart3(Request $request)
    {
        # code...
    }

    private function formatChartData($t, $d, &$collection)
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
                $collection[$strToCheck] = $collection[$strToCheck]->sum('Point');
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
}
