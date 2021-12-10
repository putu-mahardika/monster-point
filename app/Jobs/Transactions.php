<?php

namespace App\Jobs;

use App\Helpers\FunctionHelper;
use App\Helpers\LogHelper;
use App\Models\Member;
use App\Models\Merchant;
use Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;
// use Spatie\RateLimitedMiddleware\RateLimited;

class Transactions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $token;
    private $event;
    private $id;
    private $value;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($token, $event, $id, $value)
    {
        $this->token = $token;
        $this->event = $event;
        $this->id = $id;
        $this->value = $value;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        LogHelper::indexLogApi(
            $this->token,
            $this->event,
            $this->id,
            $this->value
        );

        // $merchant = Merchant::where('Token', $this->token)->first();
        // $member = Member::where('MerchentMemberKey', $this->id)
        //                 ->where('IdMerhant', $merchant->Id)
        //                 ->first();
        // $event = Event::where('Kode', $this->event)
        //               ->where('IdMerchant', $merchant->Id)
        //               ->first();

        // $data = [
        //     'code' => $log->getStatusCode(),
        //     'status' => $log->isSuccessful() ? 'success' : 'fail',
        //     'member' => [
        //         'id' => $member->MerchentMemberKey,
        //         'name' => $member->Nama,
        //     ],
        //     'event' => [
        //         'code' => $event->Kode,
        //         'name' => $event->Event
        //     ],
        //     'transaction' => [
        //         'point' => $log->isSuccessful() ? $log[0]->Point : null,
        //         'total_point_member' => $log->isSuccessful() ? $log[0]->MemberPoint : null,
        //         'datetime' => $log->isSuccessful() ? $log[0]->CreateDate : null
        //     ],
        // ];
    }
}
