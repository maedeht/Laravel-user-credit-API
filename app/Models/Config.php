<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    public $fillable = [
        'name',
        'value',
        'active'
    ];

    public function scopeRegisterCredit($query)
    {
        return $query->where('name', 'registration-credit');
    }
}
