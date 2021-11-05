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

Route::get('/billing-company', function () {
    return view('/pages/billing/billing-company');
});

Route::get('/merchants', function () {
    return view('pages.merchant.index');
});

Route::get('/dashboard', function () {
    return view('/pages/dashboard/index');
});

Route::get('/events', function () {
    return view('pages.event.index');
});

Route::get('/events/id/detail', function () {
    return view('pages.event.event-detail');
});

Route::get('/members', function () {
    return view('pages.member.index');
});

Route::get('/members/id/detail', function () {
    return view('pages.member.member-detail');
});

Route::get('/help', function () {
    return view('/pages/help/index');
});


