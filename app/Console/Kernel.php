<?php

namespace App\Console;

use App\Helpers\FunctionHelper;
use App\Helpers\GlobalSettingHelper;
use App\Http\Controllers\Web;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $date_exec = GlobalSettingHelper::getValueCut();
        $schedule->call([Web\BillingController::class, 'createBilling'])->monthlyOn($date_exec, '00:00');
        $schedule->call([Web\BillingController::class, 'resendInvoice'])->daily();
        $schedule->call([Web\BillingDetailController::class, 'resetPaymentStatus'])->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
