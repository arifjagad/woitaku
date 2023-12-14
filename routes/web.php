<?php

use Illuminate\Support\Facades\Route;

//Admin
use App\Http\Controllers\AdminControllers\Member\MemberController;
use App\Http\Controllers\AdminControllers\Activities\EventController;
use App\Http\Controllers\AdminControllers\Activities\CompetitionController;
use App\Http\Controllers\AdminControllers\Activities\BoothController;
use App\Http\Controllers\AdminControllers\DashboardController;
use App\Http\Controllers\AdminControllers\TransactionController;
use App\Http\Controllers\AdminControllers\AdminController;

//Event Organizer
use App\Http\Controllers\EventOrganizerControllers\DashboardController as DashboardController_EventOrganizer;
use App\Http\Controllers\EventOrganizerControllers\ProfileEOController;

//Member
use App\Http\Controllers\MemberControllers\MemberController as Index_Member;

Route::get('/', function () {
    return view('member.index', ['type_menu' => 'index']);
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('dashboard', [DashboardController::class, 'indexDashboard'])->name('dashboard');

    // Route:Admin
    Route::get('list-admin', [AdminController::class, 'indexAdmin'])->name('list-admin');
    Route::get('create-admin', [AdminController::class, 'createAdmin'])  -> name('create-admin');
    Route::post('create-admin', [AdminController::class, 'storeAdmin'])  -> name('create-admin');
    Route::get('profile-admin', [AdminController::class, 'profileAdmin'])->name('profile-admin');
    Route::put('update-admin/{id}', [AdminController::class, 'updateAdmin'])->name('update-admin');

    // Route:User
    Route::get('member', [MemberController::class, 'indexMember'])->name('member');
    Route::get('event-organizer', [MemberController::class, 'indexEventOrganizer'])->name('event-organizer');
    Route::get('event-organizer/{id}', [MemberController::class, 'indexEventOrganizerDetail'])->name('event-organizer');

    // Route:Events
    Route::get('event', [EventController::class, 'indexEvent'])->name('event');
    Route::get('/event/accept/{id}', [EventController::class, 'acceptEvent'])->name('event.accept');
    Route::get('/event/review/{id}', [EventController::class, 'reviewEvent'])->name('event.review');
    Route::put('/event/review/{id}', [EventController::class, 'reviewEvent'])->name('event.review');
    Route::get('/event/reject/{id}', [EventController::class, 'rejectEvent'])->name('event.reject');
    Route::put('/event/reject/{id}', [EventController::class, 'rejectEvent'])->name('event.reject');

    //Route:Competition
    Route::get('competition', [CompetitionController::class, 'indexCompetition'])->name('competition');

    // Route:Booth
    Route::get('booth', [BoothController::class, 'indexBooth'])->name('booth');

    // Route:Transaction
    Route::get('transaction', [TransactionController::class, 'indexTransaction'])->name('transaction');
});

Route::group(['middleware' => ['auth', 'role:event organizer', 'verified']], function () {
    Route::get('dashboard-eo', [DashboardController_EventOrganizer::class, 'indexDashboard_EventOrganizer'])->name('dashboard-eo');
    Route::get('profile-eo', [ProfileEOController::class, 'indexProfileEO'])->name('profile-eo');
    Route::put('update-password-eo/{id}', [ProfileEOController::class, 'updatePasswordEO'])->name('update-password-eo');
    Route::put('update-profile-eo/{id}', [ProfileEOController::class, 'updateProfileEO'])->name('update-profile-eo');
});

Route::group(['middleware' => ['auth', 'role:member']], function () {
    Route::get('member.index', [Index_Member::class, 'index'])->name('index');
});

