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

    public static function getDateCutBilling()
    {
        $date_exec = GlobalSetting::where('Kode', 'Cut')->pluck('Value')->first();
        return $date_exec;
    }

    public static function getInvoiceDetails($merchant)
    {
        // $data = array();
        $bulanIni = Carbon::today()->format('F Y');
        $bulanLalu = Carbon::today()->subMonth()->format('F Y');
        $billing = Billing::where('IdMerchant', $merchant->Id)->orderBy('CreateDate', 'desc')->first();
        $sisaHitBulanLalu = Billing::where('IdMerchant', $merchant->Id)->where('Id', '<', $billing->Id)->orderBy('Id', 'desc')->pluck('sisa')->first();
        $limitHit = GlobalSetting::where('Kode', 'Total Hit')->pluck('Value')->first();
        $tarif = GlobalSetting::where('Kode', 'Price')->pluck('Value')->first();

        $subject = '[INVOICE] '.$billing->InvoiceNumber;
        $view = 'mail.send-invoice';

        $details = [
            'noInvoice' => $billing->InvoiceNumber,
            // 'tglInvoice' => $tglInvoice,
            // 'tglInvoice' => Carbon::createFromFormat('d F Y',$billing->CreateDate)->toDateTimeString(),
            'tglInvoice' => $billing->CreateDate->format('d F Y'),
            'namaMerchant' => $merchant->Nama,
            'bulanIni' => $bulanIni,
            'bulanLalu' => $bulanLalu,
            'jatuhTempo' => date('d F Y', strtotime($billing->JatuhTempo)),
            // 'jatuhTempo' => $billing->JatuhTempo->format('d F Y'),
            'totalHitBulanIni' => (int)$billing->TotalSukses,
            'sisaHitBulanIni' => (int)$billing->sisa,
            'sisaHitBulanLalu' => !is_null($sisaHitBulanLalu) ? (int)$sisaHitBulanLalu : 0,
            'totalHit' => (int)$billing->TotalSukses + $sisaHitBulanLalu,
            'hitDitagihkan' => (int)(($billing->TotalSukses + $sisaHitBulanLalu) - $billing->sisa),
            'limitHit' => (int)$limitHit,
            'Tarif' => (int)$tarif,
            'Biaya' => (int)$billing->TotalBiaya,
        ];
        $data['subject'] = $subject;
        $data['details'] = $details;
        $data['view'] = $view;
        // dd($data);
        return $data;
    }

}
