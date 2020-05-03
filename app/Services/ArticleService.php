<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 4/30/2020 AD
 * Time: 12:13
 */

namespace App\Services;

use App\Models\Config;
use App\Models\Invoice;
use App\Models\Tag;
use App\Models\Transaction;
use App\Models\UserCredit;
use Illuminate\Support\Facades\DB;

class ArticleService extends BaseService implements ArticleServiceInterface
{
    public function createArticle($user, $request)
    {
        return DB::transaction(function () use ($user, $request) {
            $article = $user->articles()->create([
                'title' => $request->input('article.title'),
                'description' => $request->input('article.description'),
                'body' => $request->input('article.body'),
            ]);

            $inputTags = $request->input('article.tagList');

            $this->addTagsToArticles($article, $inputTags);
            $transaction = Transaction::createTransactionForArticle(
                                    $user->id,
                                    $this->getArticleCreditConfig()
                                );
            Invoice::createInvoiceForArticle($user->id, $transaction->id);
            $this->userCreditUpdateForArticleCreation($user->id);

            return $article;
        });

    }

    private function addTagsToArticles($article, $inputTags)
    {
        if ($inputTags && ! empty($inputTags)) {

            $tags = array_map(function($name) {
                return Tag::firstOrCreate(['name' => $name])->id;
            }, $inputTags);

            $article->tags()->attach($tags);
        }
    }

    private function userCreditUpdateForArticleCreation($user_id)
    {
        $credit = UserCredit::where('user_id', $user_id)->first();

        $value = $credit->value - (int) $this->getArticleCreditConfig();

        $credit->updateCredit($value);

        return true;
    }
}