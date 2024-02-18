<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::withTrashed()
            ->withTrashed()
            ->when(request('title'), function ($query, $search) {
                $query->where('title', 'like', "%$search%");
            })->when(request('body'), function ($query, $search) {
                $query->where('body', 'like', "%$search%");
            })->when(request('stars'), function ($query, $stars) {
                $query->where('stars', $stars);
            })
            ->paginate();

        return $this->respondOk($reviews);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        return $this->respondCreated(Review::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return $this->respondOk($review);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        $review->update($request->validated());
        return $this->respondOk($review);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->forceDelete();
        return $this->respondNoContent();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete(Review $review)
    {
        $review->delete();
        return $this->respondNoContent();
    }
}
