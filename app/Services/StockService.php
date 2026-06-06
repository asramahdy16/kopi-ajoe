<?php

namespace App\Services;

use App\Models\MenuStock;
use App\Models\SessionStock;
use App\Models\StockEntry;
use Illuminate\Support\Facades\DB;

class StockService
{
    /**
     * Increase global stock when new stock arrives from supplier.
     */
    public function increaseGlobalStock(int $menuId, int $quantity): void
    {
        $stock = MenuStock::firstOrCreate(
            ['menu_id' => $menuId],
            ['current_stock' => 0, 'low_stock_threshold' => 10]
        );

        $stock->increment('current_stock', $quantity);
    }

    /**
     * Request stock for a selling session.
     */
    public function requestSessionStock(int $sessionId, int $menuId, int $quantity): SessionStock
    {
        return SessionStock::create([
            'session_id' => $sessionId,
            'menu_id' => $menuId,
            'qty_requested' => $quantity,
            'status' => 'pending',
        ]);
    }

    /**
     * Approve stock request for a session.
     */
    public function approveSessionStock(SessionStock $sessionStock, int $approvedQuantity): void
    {
        DB::transaction(function () use ($sessionStock, $approvedQuantity) {
            $globalStock = MenuStock::where('menu_id', $sessionStock->menu_id)->lockForUpdate()->first();

            if (!$globalStock || $globalStock->current_stock < $approvedQuantity) {
                throw new \Exception('Stok pusat tidak mencukupi.');
            }

            $globalStock->decrement('current_stock', $approvedQuantity);

            $sessionStock->update([
                'qty_approved' => $approvedQuantity,
                'qty_remaining' => $approvedQuantity,
                'status' => 'approved',
            ]);
        });
    }

    /**
     * Reduce session stock when a transaction occurs.
     */
    public function reduceSessionStock(int $sessionId, int $menuId, int $quantity): void
    {
        $sessionStock = SessionStock::where('session_id', $sessionId)
            ->where('menu_id', $menuId)
            ->where('status', 'approved')
            ->first();

        if ($sessionStock && $sessionStock->qty_remaining >= $quantity) {
            $sessionStock->decrement('qty_remaining', $quantity);
        } else {
            throw new \Exception('Stok sesi tidak mencukupi untuk item ini.');
        }
    }
}
