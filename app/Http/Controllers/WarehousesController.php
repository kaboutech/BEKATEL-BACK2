<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::all();
        return view('warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        return view('warehouses.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'location' => 'required|max:50',
            'image' => 'nullable|url|max:200'
        ]);

        Warehouse::create($validatedData);

        return redirect('/warehouses')->with('success', 'Warehouse created successfully.');
    }

    public function edit($id)
    {
        $warehouse = Warehouse::findOrFail($id);

        return view('warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'location' => 'required|max:50',
            'image' => 'nullable|url|max:200'
        ]);

        $warehouse = Warehouse::findOrFail($id);
        $warehouse->update($validatedData);

        return redirect('/warehouses')->with('success', 'Warehouse updated successfully.');
    }

    public function destroy($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete();

        return redirect('/warehouses')->with('success', 'Warehouse deleted successfully.');
    }
}