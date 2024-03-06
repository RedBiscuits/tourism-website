<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\CreateInvoiceRequest;
use App\Http\Services\Payment\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    private $_service;

    public function __construct(PaymentService $service)
    {
        $this->_service = $service;
    }

    public function getPaymentMethods()
    {
        // $response = Cache::remember('payment_methods', now()->addDay(), function () {
            return $this->_service->get_payment_methods();
        // });

        // return $this->respondOk($response);
    }

    public function createInvoice(CreateInvoiceRequest $request)
    {
        $data = $request->validated();

        $user = auth('sanctum')->user();

        $commonData = $this->_service->get_common_data($user, $data);

        $response = $this->_service->send_init_payment($commonData);
        $this->_service->create_invoice(
            $user->id,
            $response['data']['invoice_id'],
            $data['payment_method_id'],
            $data['amount'],
            $response['data']['invoice_key']
        );

        unset($response['data']['invoice_key']);

        return $response['data'];
    }

    public function fawaterak_webhook(Request $request)
    {
        $data = $request->json()->all();

        if ($data['api_key'] == env('PAYMENT_API_KEY')) {
            DB::transaction(function () use ($data) {

                $invoice = $this->_service->getInvoice($data['invoice_id'], $data['invoice_key']);

                $user = $invoice->user;

                $this->_service->updateInvoice($invoice, $data['paidAmount'], $data['payment_method']);

                $this->_service->updateUserBalance($user, $data['paidAmount']);
            });
        }

        return response()->noContent();
    }
}
