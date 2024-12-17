<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Transaction extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }

    public function currencyCode(): HasOneThrough
    {
        return $this->hasOneThrough(
            Currency::class,
            Wallet::class,
            'id',
            'id',
            'wallet_id',
            'currency_id'
        );
    }
}
