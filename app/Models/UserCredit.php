<?php

namespace App\Models;

use Eloquent as Model;

class UserCredit extends Model
{
    public $fillable = [
        'value'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
