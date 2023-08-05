<?php

namespace App\Http\Controllers;

use App\Models\BonStock;
use Illuminate\Http\Request;

class BonStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bons = BonStock::with("customer","user")->get();

        $formattedbons = $bons->map(function ($bon) {
            return [
                'id' => $bon->id,
                'Ref' => $bon->ref,
                'Livreur' => $bon->customer->user->name,
                'Colis' => $bon->colis,
                'Valid' => $bon->valid,

            ];
        });


        return response()->json([ "data"=>$formattedbons]);
    }



    public function update_bon_stock_valid(Request $request,$id)
    {

        $validatedData = $request->validate([
            'Valid' => 'required|max:1|min:0',
        ]);

        $bon = BonStock::find($id);

        if (!$bon) {
            return response()->json([
                "error" => "Bon Pas trouvé"
            ]);  
        }

        $bon->update([
            'valid' => $request->Valid,
        ]);


        return response()->json([
            "success" => "le bon ".$bon->ref." est bien Modifié"
        ]);  

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
     * @param  \App\Models\BonStock  $bonStock
     * @return \Illuminate\Http\Response
     */
    public function show(BonStock $bonStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BonStock  $bonStock
     * @return \Illuminate\Http\Response
     */
    public function edit(BonStock $bonStock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BonStock  $bonStock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BonStock $bonStock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BonStock  $bonStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(BonStock $bonStock)
    {
        //
    }
}
