<?php

use App\Helpers\EmailChangeHelper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
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
        Route::get('chart2', [Web\DashboardController::class, 'chart2'])->name('chart2');
        Route::get('chart3', [Web\DashboardController::class, 'chart3'])->name('chart3');
    });

    Route::resource('profile', Web\UserControler::class);
    Route::resource('merchants', Web\MerchantController::class);

    Route::get('members/getMembers', [Web\MemberController::class, 'getMembers'])->name('members.getMembers');
    Route::resource('members', Web\MemberController::class);

    Route::resource('events', Web\EventController::class);
    Route::post('event-test/{event}', [Web\EventController::class, 'eventTest'])->name('event-test');

    Route::get('settings/getSettings', [Web\GlobalSettingController::class, 'getSettings'])->name('settings.getSettings');
    Route::resource('settings', Web\GlobalSettingController::class);

    Route::resource('billings', Web\BillingController::class);

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

});

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

//riset swagger
// Route::get('/greet', [GreetingController::class, 'greets']);


