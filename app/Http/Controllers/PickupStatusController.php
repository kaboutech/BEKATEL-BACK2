<?php

namespace App\Http\Controllers;

use App\Models\PickupStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PickupStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $PickupStatus = PickupStatus::all();

        $formatted_PickupStatus = $PickupStatus->map(function ($PickupStatu) {
            return [
                'Nom' => $PickupStatu->name,
                'Couleur' => $PickupStatu->color,
            ];
        });
        return response()->json([ "data"=>$formatted_PickupStatus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pickup_statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        PickupStatus::create($validatedData);
        return redirect()->route('pickup_statuses.index')->with('success', 'Pickup status created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PickupStatus  $pickupStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(PickupStatus $pickupStatus)
    {
        return view('pickup_statuses.edit', compact('pickupStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PickupStatus  $pickupStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255'
        ]);

        $pickupStatus = PickupStatus::findOrFail($id);
        $pickupStatus->update($validatedData);

        return redirect()->route('pickup-statuses.index')->with('success', 'Pickup status updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PickupStatus  $pickupStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(PickupStatus $pickupStatus)
    {
        $pickupStatus->delete();
        return redirect()->route('pickup_statuses.index')->with('success', 'Pickup status deleted successfully');
    }
}