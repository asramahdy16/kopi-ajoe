<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    public $timestamps = false;

    protected $fillable = ['transaction_id', 'menu_id', 'quantity', 'price_at_sale', 'subtotal'];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'price_at_sale' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
