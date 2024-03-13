<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reservations\CreateReservationRequest;
use App\Http\Requests\Reservations\UpdateReservationRequest;
use App\Http\Services\Payment\PaymentService;
use App\Http\Services\ReservationService;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ReservationController extends Controller
{
    private ReservationService $service;
    private PaymentService $payment_service;

    public function __construct(
        ReservationService $reservation_service,
        PaymentService $payment_service
    ) {
        $this->service = $reservation_service;
        $this->payment_service = $payment_service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(!auth('sanctum')->check(), Response::HTTP_UNAUTHORIZED, 'Unauthorized');

        $query = Reservation::query();
        $reservations = (new ReservationService($query))
            ->applyFilters(request()->all())
            ->with('tour')
            ->paginate();

        return $this->respondOk($reservations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateReservationRequest $request)
    {
        $fields = $this->service->format($request->validated());
        DB::beginTransaction();

        $reservation = Reservation::create($fields);

        $response = $this->payment_service->send_init_payment(
            $this->payment_service->get_common_data($fields)
        );

        $invoice = $this->payment_service->create_invoice(
            $reservation->uid,
            $response['data']['invoice_id'],
            $fields['payment_method_id'],
            $fields['total_amount'],
            $fields['currency'],
            $response['data']['invoice_key']
        );

        DB::commit();

        return $this->respondOK([
            'reservation' => $reservation,
            'invoice' => $invoice,
            'payment' => $response
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        return $this->respondOk($reservation->load('tour'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $reservation->update($request->validated());

        return $this->respondOk($reservation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        abort_if(!auth('sanctum')->check(), Response::HTTP_UNAUTHORIZED, 'Unauthorized');

        $reservation->delete();

        return $this->respondNoContent();
    }
}
