<?php

namespace App\Http\Controllers;

use App\Models\BonReturn;
use App\Models\BonReturnDetails;
use Illuminate\Http\Request;

class BonReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bons = BonReturn::with("customer","user")->get();

        $formattedbons = $bons->map(function ($bon) {
            return [
                'id' => $bon->id,
                'Ref' => $bon->ref,
                'Client' => $bon->customer->user->name,
                'Colis' => $bon->colis,
                'Valid' => $bon->valid,
            ];
        });


        return response()->json([ "data"=>$formattedbons]);
    }



    public function new_bon_return(Request $request)
    {
        $request->validate([
            "CustomerId" => "required",
            "selectedRows" => "required|array",
        ]);


        $prefix = 'BL-';
        $uniqueId = $prefix . uniqid();

        $BonReturn = BonReturn::create([
            'ref' => $uniqueId,
            'valid' => 0,
            'customer_id' => $request->CustomerId,
        ]);

        foreach ($request->selectedRows as $row) {
            BonReturnDetails::create([
                'bon_return_id' => $BonReturn->id,
                'order_id' => $row['id'],
            ]);
        }

        return response()->json([
            "success" => "le bon est ajouter avec success".$uniqueId
        ]);        
    }

    

    public function update_bon_return(Request $request,$id)
    {
        $request->validate([
            "CustomerId" => "required",
            "selectedRows" => "required|array",
            "colis" => "required",
        ]);


        $bon = BonReturn::find($id);

        if (!$bon) {
            return response()->json([
                "error" => "Bon Pas trouvé"
            ]);  
        }

        $bon->update([
            'customer_id' => $request->CustomerId,
            'colis' => $request->colis,
        ]);

       
        BonReturnDetails::where("bon_return_id",$id)->delete();
        foreach ($request->selectedRows as $row) {
            BonReturnDetails::create([
                'bon_return_id' => $bon->id,
                'order_id' => $row['id'],
            ]);
        }

        return response()->json([
            "success" => "le bon ".$bon->ref."est Modifier avec success"
        ]);        
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_bon_return($id)
    {
        $Data = BonReturnDetails::with("order",'Receiver','customer','OrderStatus')->where('bon_return_id',$id)->get();
        if (!$Data) {
            return response()->json(['error' => 'Bon pas trouver'], 404);
        }

        $formattedData = $Data->map(function ($dt) {
            return [
                'id' => $dt->order->id,
                'Ref' => $dt->order->ref,
                'Statut' => $dt->order->OrderStatus->name,
                'Client' => $dt->order->customer->user->name,
                'Adresse' => $dt->order->Receiver->adresse,
                'Montant' => $dt->order->amount,
            ];
        });


        return response()->json([ "data"=>$formattedData]);

    }


    public function update_bon_return_valid(Request $request,$id)
    {

        $validatedData = $request->validate([
            'Valid' => 'required|max:1|min:0',
        ]);

        $bon = BonReturn::find($id);

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
     * @param  \App\Models\BonReturn  $bonReturn
     * @return \Illuminate\Http\Response
     */
    public function show(BonReturn $bonReturn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BonReturn  $bonReturn
     * @return \Illuminate\Http\Response
     */
    public function edit(BonReturn $bonReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BonReturn  $bonReturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BonReturn $bonReturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BonReturn  $bonReturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(BonReturn $bonReturn)
    {
        //
    }
}
