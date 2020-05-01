<?php

namespace App\Models;

use Eloquent as Model;

class Transaction extends Model
{
    public $fillable = [
        'credit',
        'debit',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
