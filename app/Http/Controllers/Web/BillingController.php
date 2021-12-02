<?php

namespace App\Http\Controllers\Web;

use App\Helpers\FunctionHelper;
use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\Billing;
use App\Models\GlobalSetting;
use App\Models\Merchant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.billing.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function dx(Request $request, $merchant_id)
    {
        $billings = Billing::where('IdMerchant', $merchant_id)->get();
        return response()->json($billings);
    }

    public function createBilling()
    {
        $date_exec = FunctionHelper::getDateCutBilling();

        if(Carbon::today()->day == $date_exec)
        {
            $merchants = Merchant::select('Id', 'Nama')->where('Akif', 1)->get();

            foreach($merchants as $merchant)
            {

                $exec = DB::select('SET NOCOUNT ON; EXEC dbo.sp_GenerateBilling @IdMerchant = ?', [
                    $merchant->Id
                ]);

                if(!is_null($exec))
                {
                    $tglInvoice = Carbon::today()->format('d F Y');
                    $bulanIni = Carbon::today()->format('F Y');
                    $bulanLalu = Carbon::today()->subMonth()->format('F Y');
                    $billing = Billing::with('invoice')->where('IdMerchant', $merchant->Id)->orderBy('CreateDate', 'desc')->first();
                    $sisaHitBulanLalu = Billing::where('IdMerchant', $merchant->Id)->where('Id', '<', $billing->Id)->orderBy('Id', 'desc')->pluck('sisa')->first();
                    $limitHit = GlobalSetting::where('Kode', 'Total Hit')->pluck('Value')->first();
                    $tarif = GlobalSetting::where('Kode', 'Price')->pluck('Value')->first();


                    $details = [
                        'noInvoice' => $billing->invoice->no_invoice,
                        'tglInvoice' => $tglInvoice,
                        'namaMerchant' => $merchant->Nama,
                        'bulanIni' => $bulanIni,
                        'bulanLalu' => $bulanLalu,
                        'totalHitBulanIni' => $billing->TotalHit,
                        'sisaHitBulanIni' => $billing->sisa,
                        'sisaHitBulanLalu' => !is_null($sisaHitBulanLalu) ? (int)$sisaHitBulanLalu : 0,
                        'hitDitagihkan' => (int)(($billing->TotalSukses + $sisaHitBulanLalu) - $billing->sisa),
                        'limitHit' => $limitHit,
                        'Tarif' => $tarif,
                        'Biaya' => $billing->TotalBiaya,
                    ];

                    \Mail::to($merchant->Email)->send(new SendMail($details));
                }
            }
        }

    }
}
