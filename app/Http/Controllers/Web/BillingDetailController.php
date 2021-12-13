<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillingDetailController extends Controller
{

    public function __construct()
    {
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $billing = Billing::with('merchant')->where('Id', $request->idBilling)->first();

        DB::transaction(function() use($billing){
            $payload = [
                'transaction_details' => [
                    'order_id'      => $billing->Guid,
                    'gross_amount'  => $billing->TotalBiaya,
                ],
                'customer_details' => [
                    'first_name'    => $billing->merchant->Nama,
                    'email'         => $billing->merchant->Email,
                    // 'phone'         => '08888888888',
                    // 'address'       => '',
                ],
                'item_details' => [
                    [
                        'id'       => $billing->InvoiceNumber,
                        'price'    => $billing->TotalBiaya,
                        'quantity' => 1,
                        // 'name'     => "Billing Period : \n" . date('d F Y', strtotime($billing->date_start)) . " - " . date('d F Y', strtotime($billing->date_end))
                        'name'     => $billing->InvoiceNumber
                    ]
                ]
            ];
            $snapToken = \Midtrans\Snap::getSnapToken($payload);
            // $donation->snap_token = $snapToken;
            // $donation->save();

            $this->response['snap_token'] = $snapToken;
        });
        return response()->json($this->response);;
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
}
