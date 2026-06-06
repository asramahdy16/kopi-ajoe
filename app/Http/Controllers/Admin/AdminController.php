<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'active_sellers' => \App\Models\User::where('role', 'seller')->where('is_active', true)->count(),
            'total_motors' => \App\Models\Motor::count(),
            'total_menus' => \App\Models\Menu::count(),
            'today_sales' => \App\Models\Transaction::whereDate('created_at', today())->sum('total_amount'),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
