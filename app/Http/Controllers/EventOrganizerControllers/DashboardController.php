<?php

namespace App\Http\Controllers\EventOrganizerControllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function indexDashboard_EventOrganizer(){
        $authId = auth()->id();

        $data = DB::table('users')
            ->join('event_organizer', 'users.id', '=', 'event_organizer.id_user')
            ->select('users.*', 'event_organizer.*')
            ->where('users.id', $authId)
            ->first();
        
        // Menghitung jumlah data dari tabel detail_event
        $eventsCount = DB::table('detail_event')
            ->where('id_eo', $authId)
            ->count();

        // Menghitung jumlah data dari tabel detail_competition
        $competitionCount = DB::table('detail_competition')
            ->join('detail_event', 'detail_event.id', '=', 'detail_competition.id_event')
            ->where('id_eo', $authId)
            ->count();

        // Menghitung jumlah data dari tabel booth_rental
        $boothCount = DB::table('booth_rental')
            ->join('detail_event', 'detail_event.id', '=', 'booth_rental.id_event')
            ->where('id_eo', $authId)
            ->count();

        // Menghitung jumlah data dari tabel transaction
        $totalAmount = DB::table('transaction')
            ->join('detail_event', 'detail_event.id', '=', 'transaction.id_event')
            ->where('id_eo', $authId)
            ->where('transaction.transaction_status', '=', 'success')
            ->whereYear('transaction.created_at', now()->year)
            ->sum('transaction.transaction_amout');
            
        $totalTransaction = DB::table('transaction')
            ->join('detail_event', 'detail_event.id', '=', 'transaction.id_event')
            ->join('ticket', 'ticket.id_transaction', '=', 'transaction.id')
            ->where('id_eo', $authId)
            ->where('transaction.transaction_status', '=', 'success')
            ->whereYear('transaction.created_at', now()->year)
            ->count();

        // Menghitung jumlah data per bulan dari tabel detail_event
        $totalAmoutGraph = DB::table('transaction')
            ->join('detail_event', 'detail_event.id', '=', 'transaction.id_event')
            ->select(DB::raw('MONTH(transaction.created_at) as month'), DB::raw('SUM(transaction.transaction_amout) as total'))
            ->groupBy(DB::raw('MONTH(transaction.created_at)'))
            ->where('detail_event.id_eo', $authId)
            ->where('transaction.transaction_status', '=', 'success')
            ->get();

        // Menghitung jumlah data per bulan dari tabel detail_event
        $detailEventData = DB::table('detail_event')
            ->select(DB::raw('MONTH(start_date) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(start_date)'))
            ->where('detail_event.verification', '=', 'accepted')
            ->where('detail_event.id_eo', $authId)
            ->get();

        // Menghitung jumlah data per bulan dari tabel detail_competition
        $detailCompetitionData = DB::table('detail_competition')
            ->join('detail_event', 'detail_event.id', '=', 'detail_competition.id_event')
            ->select(DB::raw('MONTH(detail_event.start_date) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(detail_event.start_date)'))
            ->where('detail_event.id_eo', $authId)
            ->get();

        // Menghitung jumlah data per bulan dari tabel booth_rental
        $boothRentalData = DB::table('booth_rental')
            ->join('detail_event', 'detail_event.id', '=', 'booth_rental.id_event')
            ->select(DB::raw('MONTH(detail_event.start_date) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(detail_event.start_date)'))
            ->where('detail_event.id_eo', $authId)
            ->get();

        // Menampilkan 5 event terpopuler untuk tiap bulan (berdasarkan jumlah transaksi)
        $eventPopular = DB::table('detail_event')
            ->join('transaction', 'transaction.id_event', 'detail_event.id')
            ->join('ticket', 'ticket.id_transaction', '=', 'transaction.id')
            ->where('detail_event.id_eo', $authId)
            ->whereMonth('transaction.created_at', now()->month)
            ->select([
                'detail_event.id',
                'detail_event.event_name',
                'detail_event.featured_image',
                DB::raw('COUNT(ticket.id) as total_tickets'), // Jumlah tiket
                DB::raw('COUNT(transaction.id) as total_transactions'), // Jumlah transaksi
                DB::raw('SUM(transaction.transaction_amout / transaction.qty) as total_transaction_amount'), // Total transaksi
            ])
            ->groupBy('detail_event.id', 'detail_event.event_name')
            ->orderByDesc('total_transactions')
            ->take(5)
            ->get();

        $transaction = DB::table('users')
            ->join('detail_event', 'detail_event.id_eo', '=', 'users.id')
            ->join('transaction', 'transaction.id_event', '=', 'detail_event.id')
            ->join('payment_methods', 'payment_methods.id', '=', 'transaction.id_payment_methods')
            ->where('detail_event.id_eo', $authId)
            ->orderByDesc('transaction.created_at')
            ->take(10)
            ->select('users.*', 'detail_event.*', 'payment_methods.*', 'transaction.*')
            ->get();


        return view('event_organizer.dashboard-eo', 
            compact(
                'data', 
                'eventsCount', 
                'competitionCount', 
                'boothCount', 
                'totalAmount',
                'totalTransaction',
                'detailEventData',
                'detailCompetitionData',
                'boothRentalData',
                'eventPopular',
                'transaction',
                'totalAmoutGraph',
            ), 
            ['type_menu' => 'event_organizer.dashboard-eo'],
        );
    }

    
}