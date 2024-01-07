<?php

use Illuminate\Support\Facades\Route;

//Admin
use App\Http\Controllers\AdminControllers\EventController;
use App\Http\Controllers\AdminControllers\CompetitionController;
use App\Http\Controllers\AdminControllers\BoothController;
use App\Http\Controllers\AdminControllers\DashboardController;
use App\Http\Controllers\AdminControllers\TransactionController;
use App\Http\Controllers\AdminControllers\AdminController;
use App\Http\Controllers\AdminControllers\UserController;
//Event Organizer
use App\Http\Controllers\EventOrganizerControllers\DashboardController as DashboardController_EventOrganizer;
use App\Http\Controllers\EventOrganizerControllers\ProfileEOController;
use App\Http\Controllers\EventOrganizerControllers\EventEOController;
use App\Http\Controllers\EventOrganizerControllers\PaymentMethodController;
use App\Http\Controllers\EventOrganizerControllers\CompetitionEOController;
use App\Http\Controllers\EventOrganizerControllers\BoothEOController;

//Member
use App\Http\Controllers\MemberControllers\MemberController as Index_Member;
use App\Http\Controllers\MemberControllers\ProfileController;
use App\Http\Controllers\MemberControllers\DetailEventController;
use App\Http\Controllers\MemberControllers\MemberTransactionController;
use App\Http\Controllers\MemberControllers\ListEventController;





// Route untuk usertype Admin
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('dashboard', [DashboardController::class, 'indexDashboard'])->name('dashboard');

    // Route:Admin
    Route::get('list-admin', [AdminController::class, 'indexAdmin'])->name('list-admin');
    Route::get('create-admin', [AdminController::class, 'createAdmin'])  -> name('create-admin');
    Route::post('create-admin', [AdminController::class, 'storeAdmin'])  -> name('create-admin');
    Route::get('profile-admin', [AdminController::class, 'profileAdmin'])->name('profile-admin');
    Route::put('update-admin/{id}', [AdminController::class, 'updateAdmin'])->name('update-admin');
    Route::put('update-password-admin/{id}', [AdminController::class, 'updatePasswordAdmin'])->name('update-password-admin');

    // Route:User
    Route::get('member', [UserController::class, 'indexMember'])->name('member');
    Route::get('event-organizer', [UserController::class, 'indexEventOrganizer'])->name('event-organizer');
    Route::get('event-organizer/{id}', [UserController::class, 'indexEventOrganizerDetail'])->name('event-organizer');

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

// Route untuk usertype Event Organizer
Route::group(['middleware' => ['auth', 'role:event organizer', 'verified']], function () {
    // Route:Dashboard
    Route::get('dashboard-eo', [DashboardController_EventOrganizer::class, 'indexDashboard_EventOrganizer'])->name('dashboard-eo');
    
    // Route:Profile
    Route::get('profile-eo', [ProfileEOController::class, 'indexProfileEO'])->name('profile-eo');
    Route::put('update-password-eo/{id}', [ProfileEOController::class, 'updatePasswordEO'])->name('update-password-eo');
    Route::put('update-profile-eo/{id}', [ProfileEOController::class, 'updateProfileEO'])->name('update-profile-eo');
    
    // Rote:Event
    Route::get('event-eo', [EventEOController::class, 'indexEventEO'])->name('event-eo');
    Route::get('create-event-eo', [EventEOController::class, 'createEventEO'])->name('create-event-eo');
    Route::post('create-event-eo', [EventEOController::class, 'storeEventEO'])->name('create-event-eo');
    Route::get('edit-event-eo/{id}', [EventEOController::class, 'editEventEO'])->name('edit-event-eo');
    Route::put('update-event-eo/{id}', [EventEOController::class, 'updateEventEO'])->name('update-event-eo');
    Route::get('delete-event-eo/{id}', [EventEOController::class, 'deleteEventEO'])->name('delete-event-eo');

    // Route:Payment Method
    Route::get('payment-method', [PaymentMethodController::class, 'indexPaymentMethodEO'])->name('payment-method');
    Route::get('create-payment-method', [PaymentMethodController::class, 'createPaymentMethodEO'])->name('create-payment-method');
    Route::post('create-payment-method', [PaymentMethodController::class, 'storePaymentMethodEO'])->name('create-payment-method');
    Route::get('edit-payment-method/{id}', [PaymentMethodController::class, 'editPaymentMethodEO'])->name('edit-payment-method');
    Route::put('update-payment-method/{id}', [PaymentMethodController::class, 'updatePaymentMethodEO'])->name('update-payment-method');
    Route::get('updateStatusPaymentMethodEO', [PaymentMethodController::class, 'updateStatusPaymentMethodEO'])->name('updateStatusPaymentMethodEO');
    Route::get('delete-payment-method/{id}', [PaymentMethodController::class, 'deletePaymentMethodEO'])->name('delete-payment-method');

    // Route:Competition
    Route::get('competition-eo', [CompetitionEOController::class, 'indexCompetitionEO'])->name('competition-eo');
    Route::get('create-competition-eo', [CompetitionEOController::class, 'createCompetitionEO'])->name('create-competition-eo');
    Route::post('create-competition-eo', [CompetitionEOController::class, 'storeCompetitionEO'])->name('create-competition-eo');
    Route::get('edit-competition-eo/{id}', [CompetitionEOController::class, 'editCompetitionEO'])->name('edit-competition-eo');
    Route::put('update-competition-eo/{id}', [CompetitionEOController::class, 'updateCompetitionEO'])->name('update-competition-eo');
    Route::get('delete-competition-eo/{id}', [CompetitionEOController::class, 'deleteCompetitionEO'])->name('delete-competition-eo');

    // Route:Booth
    Route::get('booth-eo', [BoothEOController::class, 'indexBoothEO'])->name('booth-eo');
    Route::get('create-booth-eo', [BoothEOController::class, 'createBoothEO'])->name('create-booth-eo');
    Route::post('create-booth-eo', [BoothEOController::class, 'storeBoothEO'])->name('create-booth-eo');
    Route::get('edit-booth-eo/{id}', [BoothEOController::class, 'editBoothEO'])->name('edit-booth-eo');
    Route::put('update-booth-eo/{id}', [BoothEOController::class, 'updateBoothEO'])->name('update-booth-eo');
    Route::get('delete-booth-eo/{id}', [BoothEOController::class, 'deleteBoothEO'])->name('delete-booth-eo');
});

// Route untuk usertype Member
Route::group(['middleware' => ['auth', 'role:member']], function () {
    // Detail
    Route::get('profile', [ProfileController::class, 'indexProfile'])->name('profile');
    Route::put('update-profile/{id}', [ProfileController::class, 'updateProfile'])->name('update-profile');
    Route::put('update-password/{id}', [ProfileController::class, 'updatePasswordProfile'])->name('update-password');

});

// Route untuk semua (bisa diakses sebelum login)
Route::get('/', [Index_Member::class, 'homeMember'])->name('home');
Route::get('/home', [Index_Member::class, 'homeMember'])->name('home');
Route::get('list-event', [ListEventController::class, 'indexListEvent'])->name('list-event');
Route::get('/search-event', [ListEventController::class, 'searchEvent'])->name('search-event');
Route::get('/filter-event', [ListEventController::class, 'filterEvent'])->name('filter-event');
Route::get('transaction', [MemberTransactionController::class, 'indexMemberTransaction'])->name('transaction');
Route::get('{id}', [DetailEventController::class, 'indexDetailEvent'])->name('detail-event');