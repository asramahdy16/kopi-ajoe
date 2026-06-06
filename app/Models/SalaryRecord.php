<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryRecord extends Model
{
    protected $fillable = [
        'session_id', 'seller_id', 'base_salary', 'total_sales',
        'commission', 'total_salary', 'status', 'approved_by', 'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'base_salary' => 'decimal:2',
            'total_sales' => 'decimal:2',
            'commission' => 'decimal:2',
            'total_salary' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function session()
    {
        return $this->belongsTo(SellingSession::class, 'session_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
