<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 5/4/2020 AD
 * Time: 14:07
 */

namespace App\Services;


interface InvoiceServiceInterface
{
    public function allByUser($user_id);
}