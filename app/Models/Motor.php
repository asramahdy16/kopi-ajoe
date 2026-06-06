<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Motor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'plate_number', 'brand', 'battery_capacity',
        'status', 'condition_notes', 'photo', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'battery_capacity' => 'integer',
        ];
    }

    public function sellingSessions()
    {
        return $this->hasMany(SellingSession::class);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available' && $this->is_active;
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')->where('is_active', true);
    }
}
