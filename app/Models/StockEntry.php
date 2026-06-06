<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockEntry extends Model
{
    const UPDATED_AT = null;

    protected $fillable = ['menu_id', 'manager_id', 'quantity', 'notes', 'entry_date'];

    protected function casts(): array
    {
        return [
            'entry_date' => 'date',
            'quantity' => 'integer',
        ];
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
