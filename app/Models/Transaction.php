<?php

namespace App\Models;

use Eloquent as Model;

class Transaction extends Model
{
    public $fillable = [
        'credit',
        'debit',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function scopeCreateTransactionForArticle($query, $user_id, $articleCost)
    {
        return $query->create([
            'debit' => (int) $articleCost,
            'user_id' => $user_id
        ]);
    }

    public function scopeCreateTransactionForComment($query, $user_id, $commentConfig)
    {
        return $query->create([
            'debit' => $commentConfig,
            'user_id' => $user_id
        ]);
    }
}
