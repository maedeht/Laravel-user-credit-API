<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 5/1/2020 AD
 * Time: 16:57
 */

namespace App\Services;


use App\Models\Config;
use App\Models\UserCredit;
use Illuminate\Support\Facades\DB;

class CommentService implements CommentServiceIterface
{
    public function createComment($article, $request)
    {
        return DB::transaction(function () use ($article, $request) {
            $user = auth()->user();
            $comment = $article->comments()->create([
                'body' => $request->input('comment.body'),
                'user_id' => $user->id,
            ]);

            $transaction = $this->createTransactionForComment($user);
            if($transaction)
            {
                $this->createInvoiceForComment($user, $transaction);
                $this->updateUserCreditForCreatingComment($user);
            }

            return $comment;
        });

    }

    private function getCommentCostConfig()
    {
        $config = Config::where('name','comment-cost')->first();
        if(is_null($config))
            return null;

        return $config->value;

    }

    private function createTransactionForComment($user)
    {
        if($this->getUserCommentsCount($user) <= 5)
            return false;
        $user->transactions()->create([
            'debit' => $this->getCommentCostConfig()
        ]);

        return $user->transactions()->orderBy('id', 'DESC')->first();
    }

    private function getUserCommentsCount($user)
    {
        return count($user->comments);
    }

    private function createInvoiceForComment($user, $transaction)
    {
        $user->invoices()->create([
            'invoice_no' => $transaction->id.'-no-'.rand(10,10000),
            'comment' => 'Article created!',
            'transaction_id' => $transaction->id
        ]);
    }

    private function updateUserCreditForCreatingComment($user)
    {
        $credit = UserCredit::firstOrCreate(['user_id' => $user->id]);

        $credit->update([
            'value' => $credit->value - (int) $this->getCommentCostConfig()
        ]);

        return $user;
    }
}