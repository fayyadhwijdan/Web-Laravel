<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //count invoice
        $pending = Invoice::where('status', 'pending')->count();
        $success = Invoice::where('status', 'success')->count();
        $expired = Invoice::where('status', 'expired')->count();
        $failed  = Invoice::where('status', 'failed')->count();

        //year, month n date
        $year   = date('Y');
        $month  = date('m');
        $day  = date('d');
		
        //statistic revenue
        $revenueDay = Invoice::where('status', 'success')->whereDay('created_at', '=', $day)->sum('grand_total');
        $revenueMonth = Invoice::where('status', 'success')->whereMonth('created_at', $month)->sum('grand_total');
        $revenueYear  = Invoice::where('status', 'success')->whereYear('created_at', $year)->sum('grand_total');
        $revenueAll   = Invoice::where('status', 'success')->sum('grand_total');

        return view('admin.dashboard.index', compact('pending', 'success', 'expired', 'failed', 'revenueDay', 'revenueMonth', 'revenueYear', 'revenueAll'));
    }
}
