<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 5/1/2020 AD
 * Time: 16:57
 */

namespace App\Services;


interface CommentServiceIterface
{
    public function createComment($article, $request);
}