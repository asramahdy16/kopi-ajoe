<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuStock;
use App\Models\StockEntry;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $stocks = MenuStock::with('menu')->whereHas('menu')->get();
        $menus = Menu::where('is_active', true)->get();
        $recentEntries = StockEntry::with(['menu', 'manager'])->whereHas('menu')->latest()->take(15)->get();

        return view('manager.stocks.index', compact('stocks', 'menus', 'recentEntries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'entry_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            // Catat stok masuk
            StockEntry::create([
                'menu_id' => $request->menu_id,
                'manager_id' => auth()->id(),
                'quantity' => $request->quantity,
                'entry_date' => $request->entry_date,
                'notes' => $request->notes,
            ]);

            // Update stok global
            $menuStock = MenuStock::firstOrCreate(
                ['menu_id' => $request->menu_id],
                ['current_stock' => 0, 'low_stock_threshold' => 10]
            );

            $menuStock->increment('current_stock', $request->quantity);
        });

        return redirect()->route('manager.stocks.index')->with('success', 'Stok berhasil ditambahkan dan stok global telah diperbarui.');
    }
}
