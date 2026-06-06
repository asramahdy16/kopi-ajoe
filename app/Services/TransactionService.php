<?php

namespace App\Services;

use App\Events\TransactionCreated;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    /**
     * Process a new transaction and its items.
     */
    public function processTransaction(int $sessionId, array $items, string $paymentMethod = 'cash', ?string $notes = null): Transaction
    {
        return DB::transaction(function () use ($sessionId, $items, $paymentMethod, $notes) {
            $totalAmount = 0;

            $transaction = Transaction::create([
                'session_id' => $sessionId,
                'payment_method' => $paymentMethod,
                'notes' => $notes,
                'created_at' => now(),
            ]);

            foreach ($items as $item) {
                $subtotal = $item['quantity'] * $item['price_at_sale'];
                $totalAmount += $subtotal;

                $transaction->items()->create([
                    'menu_id' => $item['menu_id'],
                    'quantity' => $item['quantity'],
                    'price_at_sale' => $item['price_at_sale'],
                    'subtotal' => $subtotal,
                ]);
            }

            $transaction->update(['total_amount' => $totalAmount]);

            // Fire event to reduce session stock
            event(new TransactionCreated($transaction));

            return $transaction;
        });
    }
}
