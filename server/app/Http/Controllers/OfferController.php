<?php

namespace App\Http\Controllers;

use App\Http\Requests\Offer\StoreOfferRequest;
use App\Models\Offer;
use App\Http\Requests\Offer\UpdateOfferRequest;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Offer::query()
            ->when(request('title'), function ($query, $search) {
                $query->where('title', 'like', "%$search%");
            })->when(request('discount'), function ($query, $search) {
                $query->where('discount', 'like', "$search");
            })->when(request('description'), function ($query, $search) {
                $query->where('description', 'like', "%$search%");
            })->when(request('tour_id'), function ($query, $search) {
                $query->where('tour_id', $search);
            })
            ->with('media')
            ->paginate();

        return $this->respondOk($reviews);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfferRequest $request)
    {
        $offer = Offer::create($request->validated());

        if ($request->hasFile('image')) {
            $offer->addMediaFromRequest('image')->toMediaCollection();
        }

        return $this->respondCreated($offer);
    }

    /**
     * Display the specified resource.
     */
    public function show(Offer $offer)
    {
        return $this->respondOk($offer->load(['media', 'category']));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        $offer->update($request->validated());

        if ($request->hasFile('image')) {
            $offer->clearMediaCollection('images');
            $offer->addMediaFromRequest('image')->toMediaCollection();
        }

        return $this->respondOk($offer->load(['media', 'category']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();
        return $this->respondOk(null);
    }
}
