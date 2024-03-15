<?php

namespace App\Http\Services;

use App\Models\Option;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Builder;

class ReservationService
{
    protected $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function applyFilters(array $filters)
    {
        foreach ($filters as $key => $value) {
            if (method_exists($this, $method = 'filterBy' . ucfirst($key))) {
                $this->$method($value);
            }
        }

        return $this->builder;
    }

    public function format($fields)
    {
        $tour_price = Tour::find($fields['tour_id'])->price
            + Option::query()
            ->whereIn('id', $fields['options'] ?? [])
            ->where('tour_id', $fields['tour_id'])
            ->sum('price');

        $fields['total_amount'] = $tour_price * $fields['num_people'];

        return $fields;
    }

    protected function filterByName($value)
    {
        $this->builder->where('name', 'like', "$value%");
    }

    protected function filterByEmail($value)
    {
        $this->builder->where('email', 'like', "$value%");
    }

    protected function filterByPhone($value)
    {
        $this->builder->where('phone', 'like', "$value%");
    }

    protected function filterByDate($value)
    {
        $this->builder->where('date', 'like', "$value%");
    }

    protected function filterByHotelName($value)
    {
        $this->builder->where('hotel_name', 'like', "$value%");
    }

    protected function filterByRoomUid($value)
    {
        $this->builder->where('room_uid', 'like', "$value%");
    }

    protected function filterByInvoiceId($value)
    {
        $this->builder->where('invoice_id', 'like', "$value%");
    }

    protected function filterByNumPeople($value)
    {
        $this->builder->where('num_people', $value);
    }

    protected function filterByTotalAmount($value)
    {
        $this->builder->where('total_amount', $value);
    }

    protected function filterByAmountPaid($value)
    {
        $this->builder->where('amount_paid', $value);
    }

    protected function filterByTourId($value)
    {
        $this->builder->where('tour_id', $value);
    }
}
