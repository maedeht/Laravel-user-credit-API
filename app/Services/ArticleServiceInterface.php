<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 4/30/2020 AD
 * Time: 12:15
 */

namespace App\Services;


interface ArticleServiceInterface
{
    function createArticle($user, $request);
}