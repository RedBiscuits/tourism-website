<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tour\StoreTourRequest;
use App\Http\Requests\Tour\UpdateTourRequest;
use App\Models\Tour;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commodities = Tour::query()
            ->when(request('name'), function ($query, $search) {
                $query->where('name', 'like', "$search%");
            })
            ->when(request('description'), function ($query, $search) {
                $query->where('description', 'like', "$search%");
            })
            ->when(request('location'), function ($query, $search) {
                $query->where('location', 'like', "$search%");
            })
            ->when(request('duration'), function ($query, $search) {
                $query->where('duration', 'like', "$search%");
            })
            ->with(['media', 'reviews'])
            ->paginate();

        return $this->respondOk($commodities);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTourRequest $request)
    {

        $tour = Tour::create($request->validated());

        if ($request->hasFile('image')) {
            $tour->addMediaFromRequest('image')->toMediaCollection();
        }

        return $this->respondCreated($tour->load(['media', 'reviews']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Tour $tour)
    {
        return $this->respondOk($tour->load(['media', 'reviews']));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTourRequest $request, Tour $tour)
    {
        $tour->update($request->validated());

        if ($request->hasFile('image')) {
            $tour->clearMediaCollection('images');
            $tour->addMediaFromRequest('image')->toMediaCollection();
        }

        return $this->respondOk($tour);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(tour $tour)
    {
        $tour->delete();
        return $this->respondOk(null);
    }
}
