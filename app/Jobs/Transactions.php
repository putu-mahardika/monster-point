<?php

namespace App\Jobs;

use App\Helpers\LogHelper;
use App\Models\Merchant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use MqttHelper;
use Request;

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

        // $member =
        // MqttHelper::publish(
        //     Str::slug(config('app.name')) . "-$token",

        // );

    }
}
