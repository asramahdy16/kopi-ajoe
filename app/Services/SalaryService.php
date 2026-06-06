<?php

namespace App\Services;

use App\Events\SalaryApproved;
use App\Models\SalaryRecord;
use App\Models\SellingSession;
use Illuminate\Support\Facades\DB;

class SalaryService
{
    /**
     * Calculate salary for a completed selling session.
     */
    public function calculateForSession(SellingSession $session): SalaryRecord
    {
        return DB::transaction(function () use ($session) {
            $seller = $session->seller;
            
            $totalSales = $session->totalSales();
            $baseSalary = $seller->base_salary;
            
            // Komisi = (Persentase Komisi / 100) * Total Penjualan
            $commission = ($seller->commission_rate / 100) * $totalSales;
            
            $totalSalary = $baseSalary + $commission;

            return SalaryRecord::updateOrCreate(
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
        });
    }

    /**
     * Approve salary record.
     */
    public function approveSalary(SalaryRecord $salaryRecord, int $managerId): void
    {
        $salaryRecord->update([
            'status' => 'approved',
            'approved_by' => $managerId,
        ]);

        event(new SalaryApproved($salaryRecord));
    }
}
