<?php

namespace App\Http\Controllers\Api;


use App\RealWorld\Transformers\InvoiceTransformer;
use App\Services\InvoiceServiceInterface;
use Illuminate\Http\Request;

class InvoiceController extends ApiController
{
    private $invoiceService;

    public function __construct(InvoiceServiceInterface $invoiceService,
                                InvoiceTransformer $invoiceTransformer)
    {
        $this->invoiceService = $invoiceService;
        $this->transformer = $invoiceTransformer;
        $this->middleware('jwt.auth');
    }

    public function index()
    {
        $invoices = $this->invoiceService->allByUser(auth()->user());

        return $this->respondWithTransformer($invoices);
    }
}
