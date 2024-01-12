<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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

        // Menghitung jumlah data per bulan dari tabel detail_event
        $detailEventData = DB::table('detail_event')
            ->select(DB::raw('MONTH(start_date) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(start_date)'))
            ->where('detail_event.verification', '=', 'accepted')
            ->get();

        // Menghitung jumlah data per bulan dari tabel detail_competition
        $detailCompetitionData = DB::table('detail_competition')
            ->join('detail_event', 'detail_event.id', '=', 'detail_competition.id_event')
            ->select(DB::raw('MONTH(detail_event.start_date) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(detail_event.start_date)'))
            ->get();

        // Menghitung jumlah data per bulan dari tabel booth_rental
        $boothRentalData = DB::table('booth_rental')
            ->join('detail_event', 'detail_event.id', '=', 'booth_rental.id_event')
            ->select(DB::raw('MONTH(detail_event.start_date) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(detail_event.start_date)'))
            ->get();

        // Contoh: Mendapatkan total transaksi per bulan

        return view('admin.dashboard', 
            compact(
                'adminCount', 
                'eventOrganizerCount', 
                'eventsCount', 
                'membersCount',
                'usersTodayCount',
                'usersThisWeekCount',
                'usersThisMonthCount',
                'usersThisYearCount',
                'usersYesterdayCount',
                'usersLastWeekCount',
                'usersLastMonthCount',
                'usersLastYearCount',
                'detailEventData',
                'detailCompetitionData',
                'boothRentalData'
            ),
            ['datas' => $datas], 
            ['type_menu' => 'dashboard'],
        );
    }

}