<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SellingSession;
use App\Models\SessionStock;
use App\Models\MenuStock;
use App\Models\SalaryRecord;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    public function index()
    {
        $today = today();
        
        $pendingSessions = SellingSession::with(['seller', 'motor', 'sessionStocks.menu'])
            ->where('status', 'pending')
            ->whereDate('session_date', $today)
            ->get();
            
        $activeSessions = SellingSession::with(['seller', 'motor'])
            ->where('status', 'active')
            ->whereDate('session_date', $today)
            ->get();
            
        $completedSessions = SellingSession::with(['seller', 'motor', 'salaryRecord'])
            ->whereIn('status', ['completed', 'cancelled'])
            ->whereDate('session_date', $today)
            ->orderBy('ended_at', 'desc')
            ->get();

        return view('manager.sessions.index', compact('pendingSessions', 'activeSessions', 'completedSessions'));
    }

    public function show(SellingSession $session)
    {
        $session->load(['seller', 'motor', 'sessionStocks.menu', 'transactions.items.menu', 'salaryRecord']);
        
        return view('manager.sessions.show', compact('session'));
    }

    // Approve stock request and start session
    public function approveStock(Request $request, SellingSession $session)
    {
        if ($session->status !== 'pending') {
            return back()->with('error', 'Sesi ini sudah tidak dalam status pending.');
        }

        $request->validate([
            'stocks' => 'required|array',
            'stocks.*.approved' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($request, $session) {
            foreach ($request->stocks as $stockId => $data) {
                $sessionStock = SessionStock::findOrFail($stockId);
                
                if ($sessionStock->session_id !== $session->id) continue;

                $approvedQty = $data['approved'];
                
                // Update session stock
                $sessionStock->update([
                    'qty_approved' => $approvedQty,
                    'qty_remaining' => $approvedQty,
                    'status' => 'approved'
                ]);

                // Kurangi dari global stock
                $menuStock = MenuStock::where('menu_id', $sessionStock->menu_id)->first();
                if ($menuStock && $approvedQty > 0) {
                    $menuStock->decrement('current_stock', $approvedQty);
                }
            }

            $session->update([
                'status' => 'active',
                'manager_id' => auth()->id(),
                'started_at' => now(),
            ]);
        });

        return redirect()->route('manager.sessions.index')->with('success', 'Stok berhasil disetujui dan sesi penjual diaktifkan.');
    }

    // Close session and calculate salary
    public function closeSession(Request $request, SellingSession $session)
    {
        if ($session->status !== 'active') {
            return back()->with('error', 'Hanya sesi aktif yang bisa ditutup.');
        }

        DB::transaction(function () use ($request, $session) {
            $session->load(['sessionStocks', 'transactions', 'seller']);
            
            // Kembalikan sisa stok ke gudang
            foreach ($session->sessionStocks as $stock) {
                if ($stock->qty_remaining > 0) {
                    $menuStock = MenuStock::where('menu_id', $stock->menu_id)->first();
                    if ($menuStock) {
                        $menuStock->increment('current_stock', $stock->qty_remaining);
                    }
                }
            }

            // Hitung Penjualan
            $totalSales = $session->transactions->sum('total_amount');
            
            // Hitung Upah
            $seller = $session->seller;
            $baseSalary = $seller->base_salary ?? 0;
            $commissionRate = $seller->commission_rate ?? 0;
            
            $commission = ($totalSales * $commissionRate) / 100;
            $totalSalary = $baseSalary + $commission;

            // Buat Salary Record
            SalaryRecord::updateOrCreate(
                ['session_id' => $session->id],
                [
                    'seller_id' => $seller->id,
                    'base_salary' => $baseSalary,
                    'total_sales' => $totalSales,
                    'commission' => $commission,
                    'total_salary' => $totalSalary,
                    'status' => 'pending',
                ]
            );

            // Tutup Sesi
            $session->update([
                'status' => 'completed',
                'ended_at' => now(),
                'manager_notes' => $request->manager_notes ?? null
            ]);
            
            // Note: motor harus dibuat available kembali
            $session->motor->update(['status' => 'available']);
        });

        return redirect()->route('manager.sessions.show', $session)->with('success', 'Sesi berhasil ditutup dan upah telah dikalkulasi.');
    }
}
