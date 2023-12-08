<?php

namespace App\Http\Controllers;
use Laravel\Fortify\Fortify;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function indexDashboard(){
        $datas = DB::table('users');

        // Hitung data
        $adminCount = DB::table('users')
            ->where('usertype', 'admin')
            ->count();
        $eventOrganizerCount = DB::table('event_organizer')
            ->count();
        $eventsCount = DB::table('detail_event')
            ->count();
        $membersCount = DB::table('detail_member')
            ->count();

        // Data pengguna tampil
        $usersTodayCount = DB::table('users')
            ->whereDate('created_at', today())
            ->whereNotIn('usertype', ['admin'])
            ->count();
        $usersThisWeekCount = DB::table('users')
            ->whereBetween('created_at', [today()->startOfWeek(), today()->endOfWeek()])
            ->whereNotIn('usertype', ['admin'])
            ->count();
        $usersThisMonthCount = DB::table('users')
            ->whereMonth('created_at', today())
            ->whereNotIn('usertype', ['admin'])
            ->count();
        $usersThisYearCount = DB::table('users')
            ->whereYear('created_at', today())
            ->whereNotIn('usertype', ['admin'])
            ->count();

        // Data pengguna sebelumnya  
        $usersYesterdayCount = DB::table('users')
            ->whereDate('created_at', today()->subDay())
            ->whereNotIn('usertype', ['admin'])
            ->count();
        $usersLastWeekCount = DB::table('users')
            ->whereBetween('created_at', [today()->subWeek()->startOfWeek(), today()->subWeek()->endOfWeek()])
            ->whereNotIn('usertype', ['admin'])
            ->count();
        $usersLastMonthCount = DB::table('users')
            ->whereMonth('created_at', today()->subMonth())
            ->whereNotIn('usertype', ['admin'])
            ->count();
        $usersLastYearCount = DB::table('users')
            ->whereYear('created_at', today()->subYear())
            ->whereNotIn('usertype', ['admin'])
            ->count();

        // Hitung Transaksi
        $monthlyData = DB::table('transaction')
            ->selectRaw('MONTH(DATE_FORMAT(transaction_date, "%Y-%m-%d")) as month, SUM(transaction_amout) as total_amount')
            ->where('payment_status', 'paid')
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get();

        // Latest Transaction
        $latestTransactions = DB::table('transaction')
            ->join('detail_member', 'transaction.id_member', '=', 'detail_member.id')
            ->join('users', 'detail_member.id', '=', 'users.id')
            ->join('detail_event', 'transaction.id_event', '=', 'detail_event.id')
            ->latest('transaction.created_at')
            ->take(4)
            ->get();

        // Contoh: Mendapatkan total transaksi per bulan

        return view('pages.dashboard', 
            compact(
                'adminCount', 
                'eventOrganizerCount', 
                'eventsCount', 
                'membersCount',
                'latestTransactions',
                'monthlyData',
                'usersTodayCount',
                'usersThisWeekCount',
                'usersThisMonthCount',
                'usersThisYearCount',
                'usersYesterdayCount',
                'usersLastWeekCount',
                'usersLastMonthCount',
                'usersLastYearCount'
            ),
            ['datas' => $datas], 
            ['type_menu' => 'dashboard'],
        );
    }

}