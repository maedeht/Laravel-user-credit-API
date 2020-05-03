<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 5/1/2020 AD
 * Time: 22:21
 */

namespace App\Services;


use App\Models\Config;
use App\Notifications\UserCreditWarningNotification;

class BaseService
{
    protected function getRegistrationCreditConfig()
    {
        $config = Config::registerCredit()->first();

        return $config ? $config->value : '';

    }

    protected function getArticleCreditConfig()
    {
        $config = Config::articleCost()->first();

        return $config ? $config->value : '';

    }

    protected function getCommentCreditConfig()
    {
        $config = Config::commentCost()->first();

        return $config ? $config->value : '';

    }
}