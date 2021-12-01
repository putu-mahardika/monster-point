<?php

namespace Database\Seeders;

use App\Models\GlobalSetting;
use Illuminate\Database\Seeder;

class GlobalSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GlobalSetting::create([
            'Kode' => 'Cut',
            'Value' => '25',
            'Keterangan' => 'Tgl create billing bulanan'
        ]);
        GlobalSetting::create([
            'Kode' => 'Total Hit',
            'Value' => '1000',
            'Keterangan' => 'Total hit dalam sebulan'
        ]);
        GlobalSetting::create([
            'Kode' => 'Price',
            'Value' => '1000',
            'Keterangan' => 'Harga per hit (Rp.)'
        ]);
        GlobalSetting::create([
            'Kode' => 'Expired',
            'Value' => '7',
            'Keterangan' => 'Masa tenggang pembayaran billing (hari)'
        ]);
    }
}
