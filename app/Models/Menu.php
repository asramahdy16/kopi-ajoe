<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'price', 'photo', 'category', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function menuStock()
    {
        return $this->hasOne(MenuStock::class);
    }

    public function sessionStocks()
    {
        return $this->hasMany(SessionStock::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function stockEntries()
    {
        return $this->hasMany(StockEntry::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
