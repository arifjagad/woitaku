<?php

namespace App\Http\Controllers\EventOrganizerControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentMethods;

class PaymentMethodController extends Controller
{
    public function indexPaymentMethodEO(){

        $userId = Auth::id();
        $data = PaymentMethods::where('id_eo', $userId)->get();

        return view('event_organizer.payment_method.payment-method', ['type_menu' => 'payment-method'], compact('data'));
    }
}