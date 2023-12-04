<?php

use App\Http\Controllers\AdminController;
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
    return view('auth.login', ['type_menu' => '']);
});

Route::middleware(['auth'])->group(function(){
    Route::get('dashboard', function () {
        return view('pages.dashboard', ['type_menu' => 'dashboard']);
    });
});

Route::get('/create-admin', function () {
    return view('pages.create-admin', ['type_menu' => 'create-admin']);
});
Route::post('create-admin', [AdminController::class, 'Add_CreateAdmin'])  -> name('create-admin');