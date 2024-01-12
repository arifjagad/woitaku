<?php

namespace App\Http\Controllers\EventOrganizerControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentMethods;
use Illuminate\Http\Request;

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

    public function storePaymentMethodEO(Request $request){
        $userId = Auth::id();

        $existingPaymentMethodsCount = PaymentMethods::where('id_eo', $userId)->count();

        if ($existingPaymentMethodsCount >= 3) {
            toast('You can only add a maximum of 3 payment methods.','error');
            return redirect()->route('create-payment-method');
        }

        try {
            $this->validate($request, [
                'bank_name' => 'required|max:100',
                'account_number' => 'required|max:100',
                'account_holder_name' => 'required|max:100',
            ]);

            $data = PaymentMethods::create([
                'id_eo' => $userId,
                'bank_name' => request('bank_name'),
                'account_number' => request('account_number'),
                'account_holder_name' => request('account_holder_name'),
                'status' => 1
            ]);

            toast('Payment Method Created!','success');
            return redirect()->route('payment-method', compact('data'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            toast('Validation Failed!', 'error');
            return redirect()->back()->withErrors($e->errors())->withInput($request->all());
        }
    }

    public function editPaymentMethodEO($id){
        $data = PaymentMethods::find($id);

        return view('event_organizer.payment_method.edit-payment-method', ['type_menu' => 'payment-method'], compact('data'));
    }

    public function updatePaymentMethodEO(Request $request, $id){
        try {
            $this->validate($request, [
                'bank_name' => 'required|max:100',
                'account_number' => 'required|max:100',
                'account_holder_name' => 'required|max:100',
            ]);

            $data = PaymentMethods::find($id);
            $data->bank_name = request('bank_name');
            $data->account_number = request('account_number');
            $data->account_holder_name = request('account_holder_name');
            $data->save();

            toast('Payment Method Updated!','success');
        return redirect()->route('payment-method');
        } catch (\Illuminate\Validation\ValidationException $e) {
            toast('Validation Failed!', 'error');
            return redirect()->back()->withErrors($e->errors())->withInput($request->all());
        }
    }

    public function updateStatusPaymentMethodEO(Request $request){
        $data = PaymentMethods::find($request->id);
        $data->status = $request->status;
        $data->save();

        toast('Payment Method Updated!','success');
        return redirect()->route('payment-method');
    }

    public function deletePaymentMethodEO($id){
        $data = PaymentMethods::find($id);
        $data->delete();

        toast('Payment Method Deleted!','success');
        return redirect()->route('payment-method');
    }
}