<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 4/30/2020 AD
 * Time: 12:13
 */

namespace App\Services;

use App\Models\Config;
use App\Models\Tag;
use App\Models\Transaction;
use App\Models\UserCredit;
use Illuminate\Support\Facades\DB;

class ArticleService implements ArticleServiceInterface
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
            $transaction = $this->createTransactionForStoringArticle($user);
            $this->userCreditUpdateForArticleCreation($user);
            $this->createInvoiceForStoringArticle($user, $transaction);

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

    private function getArticleCostConfig()
    {
        $config = Config::where('name','article-cost')->first();
        if(is_null($config))
            return null;

        return $config->value;

    }

    private function createTransactionForStoringArticle($user)
    {
        $articleCostConfig = $this->getArticleCostConfig();
        if(is_null($articleCostConfig))
            return null;
        $user->transactions()->create([
            'debit' => (int) $articleCostConfig
        ]);

        return $user->transactions()->orderBy('id', 'DESC')->first();
    }

    private function createInvoiceForStoringArticle($user, $transaction)
    {
        $articleCostConfig = $this->getArticleCostConfig();
        if(is_null($articleCostConfig))
            return null;
        $user->invoices()->create([
            'invoice_no' => $transaction->id.'-no-'.rand(10,10000),
            'comment' => 'Article created!',
            'transaction_id' => $transaction->id
        ]);
    }

    private function userCreditUpdateForArticleCreation($user)
    {
        $credit = UserCredit::firstOrCreate(['user_id' => $user->id]);

        $credit->update([
            'value' => $credit->value - (int) $this->getArticleCostConfig()
        ]);

        return $user;
    }
}