<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionStock extends Model
{
    protected $fillable = [
        'session_id', 'menu_id', 'qty_requested', 'qty_approved', 'qty_remaining', 'status',
    ];

    protected function casts(): array
    {
        return [
            'qty_requested' => 'integer',
            'qty_approved' => 'integer',
            'qty_remaining' => 'integer',
        ];
    }

    public function session()
    {
        return $this->belongsTo(SellingSession::class, 'session_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
