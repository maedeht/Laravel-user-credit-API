<?php

namespace App\Models;

use Eloquent as Model;

class Invoice extends Model
{
    public $fillable = [
        'invoice_no',
        'comment',
        'transaction_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function scopeCreateInvoiceForComment($query, $user_id, $transaction_id)
    {
        return $query->create([
            'invoice_no' => $transaction_id.'-no-'.rand(10,10000),
            'comment' => 'Comment created!',
            'transaction_id' => $transaction_id,
            'user_id' => $user_id
        ]);
    }

    public function scopeCreateInvoiceForArticle($query, $user_id, $transaction_id)
    {
        return $query->create([
            'invoice_no' => $transaction_id.'-no-'.rand(10,10000),
            'comment' => 'Article created!',
            'transaction_id' => $transaction_id,
            'user_id' => $user_id
        ]);
    }
}
