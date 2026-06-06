<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SellingSession;
use App\Models\MenuStock;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $today = today();
        
        $stats = [
            'active_sessions' => SellingSession::where('status', 'active')->whereDate('session_date', $today)->count(),
            'completed_sessions' => SellingSession::where('status', 'completed')->whereDate('session_date', $today)->count(),
            'today_sales' => Transaction::whereDate('created_at', $today)->sum('total_amount'),
            'low_stocks' => MenuStock::whereHas('menu')->whereColumn('current_stock', '<=', 'low_stock_threshold')->count(),
        ];
        
        $activeSellers = SellingSession::with(['seller', 'motor'])
            ->where('status', 'active')
            ->whereDate('session_date', $today)
            ->get();
            
        $lowStockItems = MenuStock::with('menu')
            ->whereHas('menu')
            ->whereColumn('current_stock', '<=', 'low_stock_threshold')
            ->get();

        return view('manager.dashboard', compact('stats', 'activeSellers', 'lowStockItems'));
    }
}
