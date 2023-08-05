<?php

namespace App\Http\Controllers;

use App\Models\ReclamationsType;
use Illuminate\Http\Request;

class ReclamationsTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Data = ReclamationsType::all();

        $formattedData = $Data->map(function ($dt) {
            return [
                'id' => $dt->id,
                'Nom' => $dt->name,
            ];
        });


        return response()->json([ "data"=>$formattedData]);
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
     * @param  \App\Models\ReclamationsType  $reclamationsType
     * @return \Illuminate\Http\Response
     */
    public function show(ReclamationsType $reclamationsType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReclamationsType  $reclamationsType
     * @return \Illuminate\Http\Response
     */
    public function edit(ReclamationsType $reclamationsType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReclamationsType  $reclamationsType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReclamationsType $reclamationsType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReclamationsType  $reclamationsType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReclamationsType $reclamationsType)
    {
        //
    }
}
