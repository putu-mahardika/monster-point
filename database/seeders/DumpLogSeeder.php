<?php

namespace Database\Seeders;

use App\Models\Log;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class DumpLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $berhasil = 0;
        $gagal = 0;
        $start = 121;
        $loop = rand(10,20);
        $loopStart = 1;
        $stepDate = 1;
        $date = now()->day(1);
        for ($i = 0; $i < 1; $i++) {
            try {
                $log = Http::post(route('api.v1.transaction', [
                    'token' => 'HJEX',
                    'event' => 'TRX',
                    'id' => 'AAN1',
                    'value' => 3000,
                ]));

                // if ($loopStart == $loop) {
                //     $loop = rand(10, 20);
                //     $loopStart = 1;
                //     $date->addDays($stepDate);
                // }

                // $log = Log::where('Id', $start)->update([
                //     'CreateDate' => $date->toDateTimeString(),
                // ]);

                // $loopStart++;
                // $start++;

                if($log->status() >= 200 && $log->status() < 300) {
                    $berhasil++;
                    echo "Berhasil! ".now()->toTimeString()." #$i\n";
                }
                else {
                    $gagal++;
                    echo "Gagal! ".now()->toTimeString()." #$i\n";
                }

            } catch (\Exception $e) {
                $gagal++;
                echo "Gagal! ".now()->toTimeString()." #$i\n";
                // if ($i < 1) {
                //     echo $e->getMessage();
                // }
            }
        }

        echo "Berhasil\t: $berhasil\n";
        echo "Gagal\t: $gagal\n";
    }
}
