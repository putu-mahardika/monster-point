<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/test', function () {
    return view('/test');
});
Route::get('/', function () {
    return view('/home');
});
Route::get('/register', function () {
    return view('register');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/email-success', function () {
    return view('email-success');
});
Route::get('/confirm-email', function () {
    return view('confirm-email');
});
Route::get('/billing', function () {
    return view('/pages/billing/index');
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
Route::get('/merchant', function () {
    return view('/pages/merchant-member/index');
});
Route::get('/member-detail', function () {
    return view('/pages/merchant-member/member-detail');
});
Route::get('/help', function () {
    return view('/pages/help/index');
});


