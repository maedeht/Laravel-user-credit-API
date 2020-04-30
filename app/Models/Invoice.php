<?php

namespace App\Models;

use Eloquent as Model;

class Invoice extends Model
{
    public $fillable = [
        'invoice_no',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
