<?php

namespace App\Http\Controllers;

use App\Models\BonDelivery;
use App\Models\Driver;
use App\Models\BonDeliveryDetails;
use Illuminate\Http\Request;

class BonDeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bons = BonDelivery::with("driver","user")->get();

        $formattedbons = $bons->map(function ($bon) {
            return [
                'id' => $bon->id,
                'Ref' => $bon->ref,
                'Livreur' => $bon->driver->user->name,
                'Colis' => $bon->colis,
                'Valid' => $bon->valid,
            ];
        });


        return response()->json([ "data"=>$formattedbons]);

    }


    public function update_bon_delivery_valid(Request $request,$id)
    {

        $validatedData = $request->validate([
            'Valid' => 'required|max:1|min:0',
        ]);

        $bon = BonDelivery::find($id);

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
    

    public function new_bon_delivery(Request $request)
    {
        $request->validate([
            "deliverymanId" => "required",
            "selectedRows" => "required|array",
        ]);


        $prefix = 'BL-';
        $uniqueId = $prefix . uniqid();

        $BonDelivery = BonDelivery::create([
            'ref' => $uniqueId,
            'valid' => 0,
            'driver_id' => $request->deliverymanId,
        ]);

        foreach ($request->selectedRows as $row) {
            BonDeliveryDetails::create([
                'bon_delivery_id' => $BonDelivery->id,
                'order_id' => $row['id'],
            ]);
        }

        return response()->json([
            "success" => "le bon est ajouter avec success".$uniqueId
        ]);        
    }

    

    public function update_bon_delivery(Request $request,$id)
    {
        $request->validate([
            "deliverymanId" => "required",
            "selectedRows" => "required|array",
            "colis" => "required",
        ]);


        $bon = BonDelivery::find($id);

        if (!$bon) {
            return response()->json([
                "error" => "Bon Pas trouvé"
            ]);  
        }

        $bon->update([
            'driver_id' => $request->deliverymanId,
            'colis' => $request->colis,
        ]);

       
        BonDeliveryDetails::where("bon_delivery_id",$id)->delete();
        foreach ($request->selectedRows as $row) {
            BonDeliveryDetails::create([
                'bon_delivery_id' => $bon->id,
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
    public function get_bon_delivery($id)
    {
        $Data = BonDeliveryDetails::with("order",'Receiver','OrderStatus','Customer')->where('bon_delivery_id',$id)->get();
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
     * @param  \App\Models\BonDelivery  $bonDelivery
     * @return \Illuminate\Http\Response
     */
    public function show(BonDelivery $bonDelivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BonDelivery  $bonDelivery
     * @return \Illuminate\Http\Response
     */
    public function edit(BonDelivery $bonDelivery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BonDelivery  $bonDelivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BonDelivery $bonDelivery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BonDelivery  $bonDelivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(BonDelivery $bonDelivery)
    {
        //
    }
}
