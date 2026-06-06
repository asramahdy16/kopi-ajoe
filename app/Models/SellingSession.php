<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellingSession extends Model
{
    protected $fillable = [
        'seller_id', 'motor_id', 'manager_id', 'session_date',
        'status', 'started_at', 'ended_at', 'seller_notes', 'manager_notes',
    ];

    protected function casts(): array
    {
        return [
            'session_date' => 'date',
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
        ];
    }

    // --- Relationships ---

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function motor()
    {
        return $this->belongsTo(Motor::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function sessionStocks()
    {
        return $this->hasMany(SessionStock::class, 'session_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'session_id');
    }

    public function salaryRecord()
    {
        return $this->hasOne(SalaryRecord::class, 'session_id');
    }

    // --- Scopes ---

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeToday($query)
    {
        return $query->where('session_date', today());
    }

    // --- Helpers ---

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function totalSales(): float
    {
        return $this->transactions()->sum('total_amount');
    }
}
