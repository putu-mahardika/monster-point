<?php
namespace App\Helpers;

use App\Models\GlobalSetting;



class GlobalSettingHelper {

    public static function getValueCut()
    {
        $value = GlobalSetting::where('Kode', 'Cut')->pluck('Value')->first();
        return $value;
    }

    public static function getValueTotalHit()
    {
        $value = GlobalSetting::where('Kode', 'Total Hit')->pluck('Value')->first();
        return $value;
    }

    public static function getValuePrice()
    {
        $value = GlobalSetting::where('Kode', 'Price')->pluck('Value')->first();
        return $value;
    }

    public static function getValueExpired()
    {
        $value = GlobalSetting::where('Kode', 'Expired')->pluck('Value')->first();
        return $value;
    }

    public static function getValueHitLimit()
    {
        $value = GlobalSetting::where('Kode', 'Hit Limit')->pluck('Value')->first();
        return $value;
    }

    public static function getpaymentExpTime()
    {
        $value = GlobalSetting::where('Kode', 'Payment Exp Time')->pluck('Value')->first();
        return $value;
    }

}
