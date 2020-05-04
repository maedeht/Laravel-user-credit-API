<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 5/4/2020 AD
 * Time: 14:41
 */

namespace App\RealWorld\Transformers;


class InvoiceTransformer extends Transformer
{
    protected $resourceName = 'invoice';

    /**
     * Apply the transformation.
     *
     * @param $data
     * @return mixed
     */
    public function transform($data)
    {
        return [
            'invoice_no'  => $data['invoice_no'],
            'comment'  => $data['comment'],
            'transaction'       => [
                'credit' => $data['transaction']['credit'],
                'debit' => $data['transaction']['debit']
            ],
            'user'     => $data['user']['username']
        ];
    }
}