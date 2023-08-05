<?php

namespace App\Http\Controllers;

use App\Models\CarType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarTypeController extends Controller
{
    public function index()
    {
        $carTypes = CarType::all();
        return view('car_type.index', compact('carTypes'));
    }

    public function create()
    {
        return view('car_type.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required',
        ]);

        CarType::create($validatedData);

        return redirect()->route('car_type.index')
            ->with('success', 'Car type created successfully.');
    }

    public function edit($id)
    {
        $carType = CarType::findOrFail($id);
        return view('car_type.edit', compact('carType'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'type' => 'required',
        ]);

        $carType = CarType::findOrFail($id);
        $carType->update($validatedData);

        return redirect()->route('car_type.index')
            ->with('success', 'Car type updated successfully.');
    }

    public function destroy($id)
    {
        $carType = CarType::findOrFail($id);
        $carType->delete();

        return redirect()->route('car_type.index')
            ->with('success', 'Car type deleted successfully.');
    }
}