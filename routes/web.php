<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;

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

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/test', function () {
    return view('/test');
});
Route::get('/home', function () {
    return view('/home');
});
// Route::get('/register', function () {
//     return view('register');
// });
// Route::get('/login', function () {
//     return view('login');
// });
Route::get('/email-success', function () {
    return view('email-success');
});
Route::get('/confirm-email', function () {
    return view('confirm-email');
});
Route::get('/billing', function () {
    return view('/pages/billing/index');
});
Route::get('/billing-company', function () {
    return view('/pages/billing/billing-company');
});
Route::get('/company', function () {
    return view('/pages/company/index');
});
Route::get('/dashboard', function () {
    return view('/pages/dashboard/index');
});
Route::get('/event', function () {
    return view('/pages/event/index');
});
Route::get('/event-detail', function () {
    return view('/pages/event/event-detail');
});

Route::get('/merchants', function () {
    return view('/pages/merchant/index');
});
Route::get('/members', function () {
    return view('/pages/member/index');
});
Route::get('/member-detail', function () {
    return view('/pages/merchant-member/member-detail');
});
Route::get('/help', function () {
    return view('/pages/help/index');
});


Route::get('auth/{provider}', [SocialiteController::class, 'redirectToProvider']);
Route::get('auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback']);


Route::get('/coba', function () {
    try {
        DB::connection()->getPdo();
    } catch (\Exception $e) {
        die("Could not connect to the database.  Please check your configuration. error:" . $e );
    }
});


