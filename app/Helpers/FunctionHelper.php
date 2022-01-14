<?php
namespace App\Helpers;

use App\Models\Billing;
use App\Models\GlobalSetting;
use Carbon\Carbon;
use Illuminate\Support\Str;

class FunctionHelper {

    private static $blacklistFormulaKeyword = "alter and as asc between by count create delete desc distinct drop from group having in insert into is join like not on or order select set table union update values where limit begin trigger proc view index for add constraint key primary foreign collate clustered nonclustered declare exec go if use index holdlock nolock nowait paglock readcommitted readcommittedlock readpast readuncommitted repeatableread rowlock serializable snapshot tablock tablockx updlock with";

    /**
     * Format formula before save
     *
     * @param string $formula String of formula
     * @return string
     **/
    public static function formatFormula($formula)
    {
        return preg_replace(
            '!\s+!',
            ' ',
            str_replace(
                ["\r", "\n", "\t"],
                ' ',
                strip_tags(
                    stripslashes(
                        Str::of($formula)->trim()
                        )
                    )
            )
        );
    }

    /**
     * Get blacklist formula keyword
     *
     * @return array
     **/
    public static function getBlacklistFormulaKeywords()
    {
        return explode(' ', static::$blacklistFormulaKeyword);
    }

    public static function thousandsCurrencyFormat($num) {
        $sign = $num < 0 ? '-' : ''; // is negative value
        $num = abs($num);
        if ($num >= 1000) {
            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = array('K', 'M', 'B', 'T');
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];

            return $sign . $x_display;
        }

        $num = round($num, 2);
        return $sign == '-' ? $num * -1 : $num;
    }

    public static function getInvoiceDetails($merchant)
    {
        // $data = array();
        $bulanIni = Carbon::today()->format('F Y');
        $bulanLalu = Carbon::today()->subMonth()->format('F Y');
        $billing = Billing::where('IdMerchant', $merchant->Id)->orderBy('CreateDate', 'desc')->first();
        $sisaHitBulanLalu = Billing::where('IdMerchant', $merchant->Id)->where('Id', '<', $billing->Id)->orderBy('Id', 'desc')->pluck('sisa')->first();
        $limitHit = GlobalSettingHelper::getValueTotalHit();
        $tarif = GlobalSettingHelper::getValuePrice();

        $subject = 'Monster Point [INVOICE] '.$billing->InvoiceNumber;
        $view = 'mail.send-invoice';

        $details = [
            'noInvoice' => $billing->InvoiceNumber,
            'tglInvoice' => $billing->CreateDate->format('d F Y'),
            'namaMerchant' => $merchant->Nama,
            'bulanIni' => $bulanIni,
            'bulanLalu' => $bulanLalu,
            'jatuhTempo' => date('d F Y', strtotime($billing->JatuhTempo)),
            'totalHitBulanIni' => (int)$billing->TotalSukses,
            'sisaHitBulanIni' => (int)$billing->sisa,
            'sisaHitBulanLalu' => !is_null($sisaHitBulanLalu) ? (int)$sisaHitBulanLalu : 0,
            'totalHit' => (int)($billing->TotalSukses + $sisaHitBulanLalu),
            'hitDitagihkan' => (int)(($billing->TotalSukses + $sisaHitBulanLalu) - $billing->sisa),
            'floorHit' => (int)((($billing->TotalSukses + $sisaHitBulanLalu) - $billing->sisa)/$limitHit),
            'limitHit' => (int)$limitHit,
            'Tarif' => (int)$tarif,
            'Biaya' => (int)$billing->TotalBiaya,
        ];
        $data['subject'] = $subject;
        $data['details'] = $details;
        $data['view'] = $view;
        return $data;
    }

    public static function changeTransactionStatus($transaction, $type, $fraud)
    {
        $status = 0;
        if ($transaction == 'capture') {
            if ($type == 'credit_card') {

              if($fraud == 'challenge') {
                $status = 2; //pending
              } else {
                $status = 1; //success
              }

            }
        } elseif ($transaction == 'settlement') {

        $status = 1; //success

        } elseif($transaction == 'pending'){

            $status = 2; //pending

        } elseif ($transaction == 'deny') {

            $status = 3; //failed

        } elseif ($transaction == 'expire') {

            $status = 4; //expired

        } elseif ($transaction == 'cancel') {

            $status = 3; //failed

        }
        return $status;
    }

    public static function getMqttBaseTopic($merchantToken)
    {
        return Str::slug(
            config('app.name') . ' ' . $merchantToken
        );
    }
}
