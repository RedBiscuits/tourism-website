<?php

namespace App\Http\Services;

use App\Models\Option;
use App\Models\Tour;

class TourService
{
    public function create_options(Tour $tour, $options)
    {

        // Associate the options collection with the tour
        $tour->options()->saveMany($options->map(function ($optionData) {
            return new Option([
                'name' => $optionData['name'],
                'price' => $optionData['price'],
            ]);
        }));
    }
}
