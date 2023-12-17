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

    public function createPaymentMethodEO(){

        return view('event_organizer.payment_method.create-payment-method', ['type_menu' => 'payment-method']);
    }

    public function storePaymentMethodEO($request){
        $userId = Auth::id();
        $data = PaymentMethods::create([
            'id_eo' => $userId,
            'bank_name' => request('bank_name'),
            'account_number' => request('account_number'),
            'account_holder_name' => request('account_holder_name'),
        ]);

        toast('Payment Method Created!','success');
        return redirect()->route('payment-method', compact('data'));
    }

    public function editPaymentMethodEO($id){
        $data = PaymentMethods::find($id);

        return view('event_organizer.payment_method.edit-payment-method', ['type_menu' => 'payment-method'], compact('data'));
    }

    public function updatePaymentMethodEO($id){

        $data = PaymentMethods::find($id);
        $data->bank_name = request('bank_name');
        $data->account_number = request('account_number');
        $data->account_holder_name = request('account_holder_name');
        $data->save();

        toast('Payment Method Updated!','success');
        return redirect()->route('payment-method');
    }
}