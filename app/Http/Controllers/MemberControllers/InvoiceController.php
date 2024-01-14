<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class InvoiceController extends Controller
{
    public function indexInvoice($id)
    {
        $dataTransaction = DB::table('transaction')
            ->join('payment_methods', 'payment_methods.id', '=', 'transaction.id_payment_methods')
            ->where('transaction.id', '=', $id)
            ->select('payment_methods.*', 'transaction.*')
            ->first();

        $dataTransactionEvent = DB::table('transaction')
            ->join('detail_event', 'detail_event.id', '=', 'transaction.id_event')
            ->join('payment_methods', 'payment_methods.id', '=', 'transaction.id_payment_methods')
            ->where('transaction.id', '=', $id)
            ->first();

        $dataTransactionCompetition = DB::table('transaction')
            ->join('detail_competition', 'detail_competition.id', 'transaction.id_competition')
            ->join('payment_methods', 'payment_methods.id', '=', 'transaction.id_payment_methods')
            ->where('transaction.id', '=', $id)
            ->first();

        $dataTransactionBooth = DB::table('transaction')
            ->join('booth_rental', 'booth_rental.id', 'transaction.id_booth_rental')
            ->join('payment_methods', 'payment_methods.id', '=', 'transaction.id_payment_methods')
            ->where('transaction.id', '=', $id)
            ->first();

        return view ('member.invoice', compact('dataTransaction', 'dataTransactionEvent', 'dataTransactionCompetition', 'dataTransactionBooth'));
    }

    public function uploadTransaction(Request $request, $id){
        $request->validate([
            'proof_of_transaction' => 'required|file|mimes:jpg,jpeg,png,pdf|max:300',
        ]);
    
        try {
            $file = $request->file('proof_of_transaction');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePathTransaction = 'member/transaction/' . $fileName;

            Storage::disk('public')->put($filePathTransaction, File::get($file));

            DB::table('transaction')
                ->where('id', $id)
                ->update([
                    'proof_of_transaction' => $filePathTransaction,
                    'transaction_status' => 'check'
                ]);

            toast('Bukti transfer telah dikirim, mohon tunggu konfirmasi.', 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            // Menangkap kesalahan dan menangani
            toast('Terjadi kesalahan:', 'error');
            return redirect()->back();
        }
    }
}