<?php

namespace App\Services;

use App\Events\SellerCheckedOut;
use App\Events\SessionClosed;
use App\Models\SellingSession;
use Illuminate\Support\Facades\DB;

class SellingSessionService
{
    /**
     * Start a new selling session (Check-In).
     */
    public function startSession(int $sellerId, int $motorId): SellingSession
    {
        return SellingSession::create([
            'seller_id' => $sellerId,
            'motor_id' => $motorId,
            'session_date' => today(),
            'status' => 'pending', // Menunggu approval manager untuk stok awal
        ]);
    }

    /**
     * Approve session and mark as active.
     */
    public function activateSession(SellingSession $session, int $managerId): void
    {
        $session->update([
            'status' => 'active',
            'manager_id' => $managerId,
            'started_at' => now(),
        ]);
        
        $session->motor->update(['status' => 'in_use']);
    }

    /**
     * Seller checks out at the end of the day.
     */
    public function checkoutSession(SellingSession $session, ?string $notes = null): void
    {
        DB::transaction(function () use ($session, $notes) {
            $session->update([
                'status' => 'completed',
                'ended_at' => now(),
                'seller_notes' => $notes,
            ]);

            $session->motor->update(['status' => 'available']);

            // Trigger events to calculate salary and notify manager
            event(new SellerCheckedOut($session));
        });
    }

    /**
     * Manager closes the session after validating returning stock and money.
     */
    public function closeSession(SellingSession $session, ?string $managerNotes = null): void
    {
        $session->update([
            'manager_notes' => $managerNotes,
        ]);

        // Trigger event to return unsold stock to global stock
        event(new SessionClosed($session));
    }
}
