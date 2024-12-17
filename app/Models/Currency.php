<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use GlobalStatus;

    protected $casts = [
        'detail' => 'object',
    ];

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }
}
