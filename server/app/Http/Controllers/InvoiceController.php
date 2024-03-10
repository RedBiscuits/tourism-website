<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\CreateInvoiceRequest;
use App\Http\Requests\Payment\UpdateInvoiceRequest;
use App\Http\Services\Payment\PaymentService;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    private $_service;

    public function __construct(PaymentService $service)
    {
        $this->_service = $service;
    }

    public function index(Request $request)
    {

        $query = Invoice::query();

        $query->when($request->has('payment_method_id'), function ($q) use ($request) {
            return $q->where('payment_method_id', $request->input('payment_method_id'));
        });

        $query->when($request->has('amount'), function ($q) use ($request) {
            return $q->where('amount', $request->input('amount'));
        });

        $query->when($request->has('currency'), function ($q) use ($request) {
            return $q->where('currency', $request->input('currency'));
        });

        $query->when($request->has('status'), function ($q) use ($request) {
            return $q->where('status', $request->input('status'));
        });

        $query->when($request->has('invoice_number'), function ($q) use ($request) {
            return $q->where('invoice_number', 'like', $request->input('invoice_number').'%');
        });

        $query->when($request->has('invoice_key'), function ($q) use ($request) {
            return $q->where('invoice_key', 'like', $request->input('invoice_key').'%');
        });

        $query->when($request->has('payment_method'), function ($q) use ($request) {
            return $q->where('payment_method', $request->input('payment_method'));
        });

        $invoices = $query->paginate();

        return $this->respondOk($invoices);
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return $this->respondOk(null, 'Deleted');
    }

    public function show(Invoice $invoice)
    {
        return response()->json($invoice);
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->validated());

        return response()->json(['message' => 'Invoice updated']);
    }

    public function store(CreateInvoiceRequest $request)
    {
        $data = $request->validated();

        $commonData = $this->_service->get_common_data($data);

        $response = $this->_service->send_init_payment($commonData);

        $this->_service->create_invoice(
            $data['reservation_id'],
            $response['data']['invoice_id'],
            $data['payment_method_id'],
            $data['amount'],
            $data['currency'],
            $response['data']['invoice_key']
        );

        unset($response['data']['invoice_key']);

        return $response['data'];
    }
}
