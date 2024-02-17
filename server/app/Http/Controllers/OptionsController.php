<?php

namespace App\Http\Controllers;

use App\Http\Requests\Option\CreateOptionRequest;
use App\Http\Requests\Option\UpdateOptionRequest;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionsController extends Controller
{
    public function index()
    {
        $tours = Option::query()
            ->when(request('name'), function ($query, $search) {
                $query->where('name', 'like', "$search%");
            })
            ->when(request('price'), function ($query, $search) {
                $query->where('price', 'like', "$search%");
            })
            ->when(request('tour_id'), function ($query, $search) {
                $query->where('tour_id', 'like', $search);
            })
            ->with('tour')
            ->paginate();

        return $this->respondOk($tours);
    }

    public function show(Option $option)
    {
        return $this->respondOk($option->load('tour'));
    }

    public function store(CreateOptionRequest $request)
    {
        $option = Option::create($request->all());
        return $this->respondOk($option);
    }

    public function update(UpdateOptionRequest $request, Option $option)
    {
        $option->update($request->all());
        return $this->respondOk($option);
    }

    public function destroy(Option $option)
    {
        $option->delete();
        return $this->respondOk([]);
    }


}
