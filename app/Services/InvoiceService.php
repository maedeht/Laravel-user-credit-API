<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 5/4/2020 AD
 * Time: 14:05
 */

namespace App\Services;



use App\Models\Invoice;

class InvoiceService extends BaseService implements InvoiceServiceInterface
{
    public function allByUser($user)
    {
        return $user->invoices;
    }
}