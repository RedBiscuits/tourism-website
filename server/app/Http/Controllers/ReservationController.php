<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reservations\CreateReservationRequest;
use App\Http\Requests\Reservations\UpdateReservationRequest;
use App\Http\Services\ReservationService;
use App\Models\Reservation;
use Symfony\Component\HttpFoundation\Response;

class ReservationController extends Controller
{
    private ReservationService $service;

    public function __construct(ReservationService $reservation_service)
    {
        $this->service = $reservation_service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(! auth('sanctum')->check(), Response::HTTP_UNAUTHORIZED, 'Unauthorized');

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

        return $this->respondOK(Reservation::create($fields));
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
        abort_if(! auth('sanctum')->check(), Response::HTTP_UNAUTHORIZED, 'Unauthorized');

        $reservation->delete();

        return $this->respondNoContent();
    }
}
