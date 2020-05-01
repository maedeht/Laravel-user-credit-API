<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 5/1/2020 AD
 * Time: 22:21
 */

namespace App\Services;


class BaseService
{
    protected function checkForRechangeEmail()
    {
        $user = auth()->user();

        if($this->checkUserCredit(20))
        {
            // send mail
        }
    }

    protected function checkForMakingUserInactive()
    {
        $user = auth()->user();
    }

    private function checkUserCredit($value)
    {
        $user = auth()->user();
        
    }
}