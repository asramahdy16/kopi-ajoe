<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalaryRecord;

class SalaryController extends Controller
{
    public function index()
    {
        $salaries = SalaryRecord::with(['seller', 'session'])
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'paid')")
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('manager.salaries.index', compact('salaries'));
    }

    public function approve(Request $request, SalaryRecord $salary)
    {
        if ($salary->status !== 'pending') {
            return back()->with('error', 'Status upah sudah tidak pending.');
        }

        $salary->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Upah seller berhasil disetujui.');
    }
}
