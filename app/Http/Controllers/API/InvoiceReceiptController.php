<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceReceipt\CreateInvoiceReceiptRequest;
use App\Http\Requests\InvoiceReceipt\UpdateInvoiceReceiptRequest;
use App\Http\Resources\InvoiceReceipt\InvoiceReceiptResource;
use App\Models\InvoiceReceipt;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;

class InvoiceReceiptController extends Controller
{
    public function __construct()
    {

    }

    public function index(): AnonymousResourceCollection 
    {
        $invoiceReceipts = InvoiceReceipt::useFilters()->dynamicPaginate();

        return InvoiceReceiptResource::collection($invoiceReceipts);
    }

    public function store(CreateInvoiceReceiptRequest $request): JsonResponse
    {
        $invoiceReceipt = InvoiceReceipt::create($request->validated());

        return $this->responseCreated('InvoiceReceipt created successfully', new InvoiceReceiptResource($invoiceReceipt));
    }

    public function show(InvoiceReceipt $invoiceReceipt): JsonResponse
    {
        return $this->responseSuccess(null, new InvoiceReceiptResource($invoiceReceipt));
    }

    public function update(UpdateInvoiceReceiptRequest $request, InvoiceReceipt $invoiceReceipt): JsonResponse
    {
        $invoiceReceipt->update($request->validated());

        return $this->responseSuccess('InvoiceReceipt updated Successfully', new InvoiceReceiptResource($invoiceReceipt));
    }

    public function destroy(InvoiceReceipt $invoiceReceipt): JsonResponse
    {
        $invoiceReceipt->delete();

        return $this->responseDeleted();
    }

}
