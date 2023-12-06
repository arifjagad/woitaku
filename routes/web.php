<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\Activities\EventController;
use App\Http\Controllers\Activities\CompetitionController;

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

    // Route::Admin
    Route::get('list-admin', [AdminController::class, 'indexAdmin'])->name('list-admin');
    Route::get('create-admin', [AdminController::class, 'createAdmin'])  -> name('create-admin');
    Route::post('create-admin', [AdminController::class, 'storeAdmin'])  -> name('create-admin');
    Route::get('profile-admin', [AdminController::class, 'profileAdmin'])->name('profile-admin');
    Route::put('update-admin/{id}', [AdminController::class, 'updateAdmin'])->name('update-admin');

    // Route:User
    Route::get('member', [MemberController::class, 'indexMember'])->name('member');
    Route::get('event-organizer', [MemberController::class, 'indexEventOrganizer'])->name('event-organizer');

    // Route:Activities
    // Route:Events
    Route::get('event', [EventController::class, 'indexEvent'])->name('event');
    Route::get('/event/accept/{id}', [EventController::class, 'acceptEvent'])->name('event.accept');
    Route::get('/event/review/{id}', [EventController::class, 'reviewEvent'])->name('event.review');
    Route::put('/event/review/{id}', [EventController::class, 'reviewEvent'])->name('event.review');
    Route::get('/event/reject/{id}', [EventController::class, 'rejectEvent'])->name('event.reject');
    Route::put('/event/reject/{id}', [EventController::class, 'rejectEvent'])->name('event.reject');

    //Route:Competition
    Route::get('competition', [CompetitionController::class, 'indexCompetition'])->name('competition');
});
