<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\CreateInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Models\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class InvoiceController extends Controller
{
    public function __construct()
    {

    }

    public function index(): AnonymousResourceCollection
    {
        $invoices = Invoice::useFilters()->dynamicPaginate();

        return InvoiceResource::collection($invoices);
    }

    public function store(CreateInvoiceRequest $request): JsonResponse
    {
        $invoice = Invoice::create($request->validated());

        return $this->responseCreated('Invoice created successfully', new InvoiceResource($invoice));
    }

    public function show(Invoice $invoice): JsonResponse
    {
        return $this->responseSuccess(null, new InvoiceResource($invoice));
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice): JsonResponse
    {
        $invoice->update($request->validated());

        return $this->responseSuccess('Invoice updated Successfully', new InvoiceResource($invoice));
    }

    public function destroy(Invoice $invoice): JsonResponse
    {
        $invoice->delete();

        return $this->responseDeleted();
    }
}
