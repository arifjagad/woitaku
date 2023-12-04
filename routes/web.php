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

Route::get('/', function () {
    return view('pages.blank-page', ['type_menu' => '']);
});

Route::get('/login', function () {
    return view('auth.login', ['type_menu' => '']);
});

Route::get('/register', function () {
    return view('auth.register', ['type_menu' => '']);
});

Route::get('/forgot', function () {
    return view('auth.forgot', ['type_menu' => '']);
});

Route::get('/reset', function () {
    return view('auth.reset', ['type_menu' => '']);
});

Route::get('/verify', function () {
    return view('auth.verify', ['type_menu' => '']);
});
