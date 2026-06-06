<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const UPDATED_AT = null;

    protected $fillable = ['session_id', 'total_amount', 'payment_method', 'notes', 'created_at'];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'created_at' => 'datetime',
        ];
    }

    public function session()
    {
        return $this->belongsTo(SellingSession::class, 'session_id');
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
