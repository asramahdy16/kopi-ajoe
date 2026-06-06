<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuStock extends Model
{
    public $timestamps = false;

    protected $fillable = ['menu_id', 'current_stock', 'low_stock_threshold'];

    protected function casts(): array
    {
        return [
            'current_stock' => 'integer',
            'low_stock_threshold' => 'integer',
            'updated_at' => 'datetime',
        ];
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function isLowStock(): bool
    {
        return $this->current_stock <= $this->low_stock_threshold;
    }
}
