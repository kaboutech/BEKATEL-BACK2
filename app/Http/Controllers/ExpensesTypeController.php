<?php

namespace App\Http\Controllers;

use App\Models\ExpensesType;
use Illuminate\Http\Request;

class ExpensesTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $types = ExpensesType::all();

        $formatted_types = $types->map(function ($tp) {
            return [
                'id' => $tp->id,
                'Nom' => $tp->name,
            ];
        });

        return response()->json([ "data"=>$formatted_types]);
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
     * @param  \App\Models\ExpensesType  $expensesType
     * @return \Illuminate\Http\Response
     */
    public function show(ExpensesType $expensesType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpensesType  $expensesType
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpensesType $expensesType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExpensesType  $expensesType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpensesType $expensesType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpensesType  $expensesType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpensesType $expensesType)
    {
        //
    }
}
