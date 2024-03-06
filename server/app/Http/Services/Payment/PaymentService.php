<?php

namespace App\Http\Services\Payment;

use App\Models\Invoice;
use App\Models\Reservation;
use Illuminate\Support\Facades\Http;

class PaymentService
{
    // test = 'PAYMENT_TEST_URL';
    // live = 'PAYMENT_LIVE_URL';

    private $api_env = 'PAYMENT_TEST_URL';

    public function get_payment_methods()
    {
        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('PAYMENT_API_KEY'),
        ])->get(env($this->api_env) . 'getPaymentmethods')->json();
    }

    public function get_common_data($data)
    {
        return [
            'payment_method_id' => $data['payment_method_id'],
            'cartTotal' => intval($data['amount']),
            'currency' => $data['currency'] ?? 'EGP',
            'customExpireDate' => '+1 days',
            'sendEmail' => true,
            'sendSMS' => true,
            'cartItems' => [
                [
                    'name' => 'First Step Balance Payment',
                    'price' => intval($data['amount']),
                    'quantity' => '1',
                ],
            ],
            'customer' => [
                'first_name' => $data['name'],
                'last_name' => '.',
                'email' => $data['email'] ?? 'User@domain.com',
                'phone' => $data['payment_number'],
                'address' => $data['city'] ?? 'Cairo',
            ],
            // "redirectionUrls" => [
            //     "successUrl" => "https://account.firststepacademy.online/payment/success",
            //     "failUrl"=> "https://account.firststepacademy.online/payment/failed",
            //     "pendingUrl"=> "https://account.firststepacademy.online/payment/pending"
            // ],
        ];
    }

    public function send_init_payment($common_data)
    {
        $response = Http::withToken(env('PAYMENT_API_KEY'))->withHeaders([
            'Content-Type' => 'application/json',
        ])->post(env($this->api_env) . 'invoiceInitPay', $common_data);

        return $response->json();
    }

    public function create_invoice($reservation_id, $invoice_number, $payment_method_id, $amount, $currency, $invoice_key)
    {
        Invoice::create([
            'reservation_id' => $reservation_id,
            'invoice_number' => $invoice_number,
            'payment_method_id' => $payment_method_id,
            'amount' => $amount,
            'currency' => $currency,
            'invoice_key' => $invoice_key,
        ]);
    }

    public function getInvoice($invoiceId, $invoiceKey)
    {
        return Invoice::where('invoice_number', $invoiceId)
            ->where('invoice_key', $invoiceKey)
            ->firstOrFail();
    }

    public function updateInvoice($invoice, $paidAmount, $paymentMethod)
    {
        $paidAmount = floatval($paidAmount);

        $invoice->update([
            'status' => 1,
            'amount' => $paidAmount,
            'payment_method' => $paymentMethod,
        ]);
    }

    public function updateReservationBalance($res_id, $paidAmount)
    {
        Reservation::where('id', $res_id)->increment('amount_paid', $paidAmount);
    }


}
