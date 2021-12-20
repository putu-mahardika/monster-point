<?php

namespace App\Http\Controllers\Web;

use App\Helpers\FunctionHelper;
use App\Helpers\GlobalSettingHelper;
use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\BillingDetail;
use App\Models\GlobalSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $transaction_id = 'MP-' . Str::random(5);
        $payment_start = Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s');
        $duration = GlobalSettingHelper::getpaymentExpTime();
        $payment_end = Carbon::parse($payment_start)->addHours($duration);
        $billing = Billing::with('merchant')->where('Id', $request->idBilling)->first();
        BillingDetail::create([
            'status' => 0,
            'billing_id' => $billing->Id,
            'transaction_id' => $transaction_id,
            'payload' => json_encode(['payment_start' => $payment_start, 'payment_end' => $payment_end, 'duration' => $duration])
        ]);

        DB::transaction(function() use($billing, $transaction_id, $payment_start, $duration){
            $payload = [
                'transaction_details' => [
                    'order_id'      => $transaction_id,
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
                        'name'     => $billing->InvoiceNumber
                    ]
                ],
                'expiry' => [
                    'start_time' => $payment_start . "+0700",
                    'unit' => 'hours',
                    'duration' => $duration
                ]
            ];
            $snapToken = \Midtrans\Snap::getSnapToken($payload);
            $billing->snap_token = $snapToken;
            $billing->save();

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

    public function notification(Request $request)
    {
        $notif = new \Midtrans\Notification();

        dd($notif);
        DB::transaction(function() use($notif) {

            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $orderId = $notif->order_id;
            $fraud = $notif->fraud_status;
            $payment_type = $notif->payment->type;
            $bank = !is_null($notif->va_numbers[0] ? $notif->va_numbers[0]->bank : '');
            $va_number = !is_null($notif->va_numbers[0] ? $notif->va_numbers[0]->va_number : '');
            // $payment_start = $notif->transaction_time;
            $paid_at = !is_null($notif->payment_amounts[0] ? $notif->payment_amounts[0]->paid_at : '');
            $amount = !is_null($notif->payment_amounts[0] ? $notif->payment_amounts[0]->amount : '');


            $billing_detail = BillingDetail::where('transaction_id', $orderId)->orderby('created_at', 'desc')->first();
            $billing_payload = json_decode($billing_detail->payload);

            $status = FunctionHelper::changeTransactionStatus($transaction, $type, $fraud);

            BillingDetail::create([
                'status' => $status,
                'billing_id' => $billing_detail->billing_id,
                'transaction_id' => $billing_detail->transaction_id,
                'payload' => json_encode([
                                'payment_start' => $billing_payload->payment_start,
                                'payment_end' => $billing_payload->payment_end,
                                'duration' => $billing_payload->duration,
                                'paid_at' => $paid_at,
                                'payment_type' => $payment_type,
                                'bank' => $bank,
                                'va_number' => $va_number,
                                'amount' => $amount
                            ])
            ]);
        });

        return;
    }

    public function resetPaymentStatus()
    {
        $billings = Billing::with(['billing_detail' => function($q){
            $q->orderBy('created_at', 'desc')->first();
        }])->get();

        foreach ($billings as $billing) {
            $billing_detail_payload = json_decode($billing->billing_detail->payload);
            if($billing->billing_detail->status == 2)
            {
                if(Carbon::now() > $billing_detail_payload->payment_end)
                {
                    BillingDetail::create([
                        'status' => 4,
                        'billing_id' => $billing->billing_detail->billing_id,
                        'transaction_id' => $billing->billing_detail->transaction_id,
                        'payload' => json_encode([
                                        'payment_start' => $billing_detail_payload->payment_start,
                                        'payment_end' => $billing_detail_payload->payment_end,
                                        'duration' => $billing_detail_payload->duration,
                                        'paid_at' => $billing_detail_payload->paid_at,
                                        'payment_type' => $billing_detail_payload->payment_type,
                                        'bank' => $billing_detail_payload->bank,
                                        'va_number' => $billing_detail_payload->va_number,
                                        'amount' => $billing_detail_payload->amount
                                    ])
                    ]);
                }
            }
        }
    }
}
