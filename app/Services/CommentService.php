<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 5/1/2020 AD
 * Time: 16:57
 */

namespace App\Services;


use App\Models\Config;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\UserCredit;
use App\Notifications\UserCreditWarningNotification;
use Illuminate\Support\Facades\DB;

class CommentService extends BaseService implements CommentServiceIterface
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
                Invoice::createInvoiceForComment($user->id, $transaction->id);
                $this->updateUserCreditForCreatingComment($user->id);
            }

            return $comment;
        });

    }

    private function createTransactionForComment($user)
    {
        if($this->getUserCommentsCount($user) <= 5)
            return false;
        return Transaction::createTransactionForComment(
                $user->id, $this->getCommentCreditConfig());
    }

    private function getUserCommentsCount($user)
    {
        return count($user->comments);
    }

    private function updateUserCreditForCreatingComment($user_id)
    {
        $credit = UserCredit::where('user_id', $user_id)->first();
        if(is_null($credit))
            return false;
        $value = $credit->value - (int) $this->getCommentCreditConfig();
        $credit->updateCredit($value);

        return true;
    }
}