<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tour\StoreTourRequest;
use App\Http\Requests\Tour\UpdateTourRequest;
use App\Http\Services\TourService;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{

    private TourService $tour_service;


    public function __construct(TourService $service)
    {
        $this->tour_service = $service;
    }

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
            ->with(['media', 'reviews', 'options:id,tour_id,name,price'])
            ->paginate();

        return $this->respondOk($commodities);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTourRequest $request)
    {

        $tour = Tour::create($request->validated());

        if ($request->hasFile('media')) {
            $tour->addMultipleMediaFromRequest(['media'])->each(function ($fileAdder) {
                $fileAdder->toMediaCollection();
            });
        }

        $options = collect($request->input('options'));

        $this->tour_service->create_options($tour, $options);

        return $this->respondCreated($tour->load(['media', 'reviews', 'options:id,tour_id,name,price']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Tour $tour)
    {
        return $this->respondOk($tour->load(['media', 'reviews', 'options:id,tour_id,name,price']));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTourRequest $request, Tour $tour)
    {
        $tour->update($request->validated());

        if ($request->hasFile('media')) {
            $tour->addMultipleMediaFromRequest(['media'])->each(function ($fileAdder) {
                $fileAdder->toMediaCollection();
            });
        }

        return $this->respondOk($tour->load(['media', 'reviews', 'options:id,tour_id,name,price']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tour $tour)
    {
        $tour->delete();
        return $this->respondNoContent();
    }

    /**
     * Add an image to the tour's media collection.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tour $tour
     * @return \Illuminate\Http\JsonResponse
     */
    public function addImage(Request $request, Tour $tour)
    {
        $request->validate([
            'media' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $tour->addMediaFromRequest('media')->toMediaCollection();

        return response()->json(['message' => 'Image added successfully']);
    }

    /**
     * Delete a specific image from the tour's media collection.
     *
     * @param \App\Models\Tour $tour
     * @param int $mediaId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage(Tour $tour)
    {
        $tour->deleteMedia(request()->get('mediaId'));

        return response()->json(['message' => 'Image deleted successfully']);
    }
}
