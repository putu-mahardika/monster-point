<?php

use App\Helpers\EmailChangeHelper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Coba;
use App\Http\Controllers\GreetingController;
use App\Http\Controllers\Web;
use App\Models\GlobalSetting;
use App\Models\User;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// SOCIALITE AUTH ROUTES
Route::get('auth/{provider}', [SocialiteController::class, 'redirectToProvider']);
Route::get('auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback']);

// LANDING PAGE
Route::view('/', 'landing');

// AFTER LOGIN ROUTES
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [Web\DashboardController::class, 'index'])->name('index');
        Route::get('chart1', [Web\DashboardController::class, 'chart1'])->name('chart1');
        Route::get('chart1/stat', [Web\DashboardController::class, 'chart1Stat'])->name('chart1.stat');
        Route::get('chart2', [Web\DashboardController::class, 'chart2'])->name('chart2');
        Route::get('chart3', [Web\DashboardController::class, 'chart3'])->name('chart3');
        Route::get('chart-time', [Web\DashboardController::class, 'chartTime'])->name('chartTime');
        Route::post('clear-chart-cache', [Web\DashboardController::class, 'clearChartCache'])->name('clearChartCache');
    });

    Route::resource('profile', Web\UserControler::class);
    Route::resource('merchants', Web\MerchantController::class);

    Route::get('members/getMembers', [Web\MemberController::class, 'getMembers'])->name('members.getMembers');
    Route::resource('members', Web\MemberController::class);

    Route::resource('events', Web\EventController::class);
    Route::post('event-test/{event}', [Web\EventController::class, 'eventTest'])->name('event-test');

    Route::get('settings/getSettings', [Web\GlobalSettingController::class, 'getSettings'])->name('settings.getSettings');
    Route::resource('settings', Web\GlobalSettingController::class);

    Route::get('resendInvoice', [Web\BillingController::class, 'resendInvoice'])->name('billing.resendInvoice');
    Route::get('createBilling', [Web\BillingController::class, 'createBilling'])->name('billing.createBilling');
    // Route::get('payment', [Web\BillingController::class, 'payment']);

    Route::post('billing-details/payment', [Web\BillingDetailController::class, 'store']);
    Route::post('midtrans/notification', [Web\BillingDetailController::class, 'notification']);
    Route::resource('billings', Web\BillingController::class);


    Route::resource('billing-details', Web\BillingDetailController::class);

    Route::post('popup-verify/{user}', function (User $user) {
        $user->isShowPopupVerify = true;
        $user->save();
    })->name('popup-verify');

    Route::get('verify-email-change', function (Request $request) {
        return EmailChangeHelper::validateToken($request->token);
    })->name('verify-email-change');


    Route::prefix('dx')->name('dx.')->group(function () {
        Route::get('merchants', [Web\MerchantController::class, 'dx'])->name('merchants');
        Route::get('members/{merchant_id?}', [Web\MemberController::class, 'dx'])->name('members');
        Route::get('events/{merchant_id}', [Web\EventController::class, 'dx'])->name('events');
        Route::get('billings/{merchant_id}', [Web\BillingController::class, 'dx'])->name('billings');
    });

    Route::get('/invoice', function(){
        return view('/pages/billing/invoice');
    });

    //receipt
    Route::get('/receipt', function () {
        return view('pages/billing/receipt');
    });

});

Route::get('/kirim-email', [Web\MailController::class, 'index'])->name('sendMail');

Route::get('/help', function () {
    return view('/pages/help/index');
});

Route::get('/coba', function () {
    try {
        DB::connection()->getPdo();
    } catch (\Exception $e) {
        die("Could not connect to the database.  Please check your configuration. error:" . $e );
    }
});

// invoice
Route::get('/invoice', function(){
    return view('/pages/billing/invoice');
});

//receipt
Route::get('/receipt', function () {
    return view('pages/billing/receipt');
});

//test
Route::get('/test', function () {
    return view('/test');
});

// email view invoice & receipt
Route::get('/send-receipt', [Coba::class, 'index' ]);
