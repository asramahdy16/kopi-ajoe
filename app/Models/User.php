<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'address',
        'base_salary', 'commission_rate', 'is_active', 'profile_photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'base_salary' => 'decimal:2',
            'commission_rate' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    // --- Relationships ---

    public function sellingSessions()
    {
        return $this->hasMany(SellingSession::class, 'seller_id');
    }

    public function managedSessions()
    {
        return $this->hasMany(SellingSession::class, 'manager_id');
    }

    public function stockEntries()
    {
        return $this->hasMany(StockEntry::class, 'manager_id');
    }

    public function salaryRecords()
    {
        return $this->hasMany(SalaryRecord::class, 'seller_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // --- Helpers ---

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    public function activeSession()
    {
        return $this->sellingSessions()->where('status', 'active')->latest()->first();
    }
}
