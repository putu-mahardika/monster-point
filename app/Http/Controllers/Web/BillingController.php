<?php

namespace App\Http\Controllers\Web;

use App\Helpers\FunctionHelper;
use App\Helpers\GlobalSettingHelper;
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
        $merchants = Merchant::select('Id', 'Nama', 'Email')->where('Akif', 1)->get();
        // dd($merchants);
        foreach($merchants as $merchant)
        {
            try {
                DB::select('SET NOCOUNT ON; EXEC dbo.sp_GenerateBilling @IdMerchant = ?', [
                    $merchant->Id
                ]);
                $exec = true;
            } catch (\Exception $e) {
                $exec = false;
            }
            // dd($exec);
            if($exec)
            {
                $noInvoice = Billing::where('IdMerchant', $merchant->Id)->orderBy('Id', 'desc')->pluck('InvoiceNumber')->first();
                if(!is_null($noInvoice))
                {
                    $data = FunctionHelper::getInvoiceDetails($merchant);
                    // dd($data);
                    \Mail::to($merchant->Email)->send(new SendMail($data['subject'], $data['details'], $data['view']));
                } else {
                    dd('aaa');
                }

            }
        }
    }

    public function resendInvoice()
    {
        $dateCut = (int)floor(GlobalSettingHelper::getValueExpired()/2);
        dd($dateCut);
        $billings = Billing::with('merchant')
                    ->whereHas('merchant', function($q){
                        $q->where('Akif', '=', 1);
                    })
                    ->where('Terbayar', '=', '0')
                    ->get();
        foreach($billings as $billing)
        {
            $jatuhTempo = Carbon::create($billing->JatuhTempo);
            if(now() == $jatuhTempo || now() == $jatuhTempo->subDays($dateCut) || now() == $jatuhTempo->subDay())
            {
                $data = FunctionHelper::getInvoiceDetails($billing->merchant);
                // dd($data);
                \Mail::to($billing->merchant->Email)->send(new SendMail($data['subject'], $data['details'], $data['view']));
            }
        }
    }

    public function sendInvoice(Request $request)
    {
        $merchant = Merchant::select('Id', 'Nama', 'Email')->where('Id', $request->id)->get();
        if(!is_null($merchant))
        {
            $data = FunctionHelper::getInvoiceDetails($merchant);
            \Mail::to($merchant->Email)->send(new SendMail($data['subject'], $data['details'], $data['view']));
        }
    }
}
