<?php

namespace App\Http\Controllers;

use App\Models\OrderPhase;
use Illuminate\Http\Request;

class OrderPhaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $phases = OrderPhase::all();

        $formatted_phases = $phases->map(function ($ph) {
            return [
                'id' => $ph->id,
                'Nom' => $ph->name,
            ];
        });


        return response()->json([ "data"=>$formatted_phases]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\orderPhase  $orderPhase
     * @return \Illuminate\Http\Response
     */
    public function show(orderPhase $orderPhase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\orderPhase  $orderPhase
     * @return \Illuminate\Http\Response
     */
    public function edit(orderPhase $orderPhase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\orderPhase  $orderPhase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, orderPhase $orderPhase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\orderPhase  $orderPhase
     * @return \Illuminate\Http\Response
     */
    public function destroy(orderPhase $orderPhase)
    {
        //
    }
}
