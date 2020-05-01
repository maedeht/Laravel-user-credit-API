<?php

namespace App\Models;

use Eloquent as Model;

class Invoice extends Model
{
    public $fillable = [
        'invoice_no',
        'comment',
        'transaction_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
