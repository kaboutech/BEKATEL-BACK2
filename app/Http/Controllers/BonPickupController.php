<?php

namespace App\Http\Controllers;

use App\Models\BonPickup;
use App\Models\BonPickupDetails;
use Illuminate\Http\Request;

class BonPickupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bons = BonPickup::with("customer","user")->get();

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

    

    public function get_bon_pickup($id)
    {
        $Data = BonPickupDetails::with("order",'Receiver','OrderStatus','Customer')->where('bon_pickup_id',$id)->get();
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

    public function update_bon_pickup_valid(Request $request,$id)
    {

        $validatedData = $request->validate([
            'Valid' => 'required|max:1|min:0',
        ]);

        $bon = BonPickup::find($id);

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

    
    public function new_bon_pickup(Request $request)
    {
        $request->validate([
            "customerId" => "required",
            "colis" => "required",
            "selectedRows" => "required|array",
        ]);


        $prefix = 'BRA-';
        $uniqueId = $prefix . uniqid();

        $Bon = BonPickup::create([
            'ref' => $uniqueId,
            'valid' => 0,
            'customer_id' => $request->customerId,
            'colis' => $request->colis,
        ]);

        foreach ($request->selectedRows as $row) {
            BonPickupDetails::create([
                'bon_pickup_id' => $Bon->id,
                'order_id' => $row['id'],
            ]);
        }

        return response()->json([
            "success" => "le bon est ajouter avec success".$uniqueId
        ]);        
    }


    public function update_bon_pickup(Request $request,$id)
    {
        $request->validate([
            "customerId" => "required",
            "colis" => "required",
            "selectedRows" => "required|array",
        ]);


        $bon = BonPickup::find($id);

        if (!$bon) {
            return response()->json([
                "error" => "Bon Pas trouvé"
            ]);  
        }

        $bon->update([
            'customer_id' => $request->customerId,
            'colis' => $request->colis,
        ]);

       
        BonPickupDetails::where("bon_pickup_id",$id)->delete();
        foreach ($request->selectedRows as $row) {
            BonPickupDetails::create([
                'bon_pickup_id' => $bon->id,
                'order_id' => $row['id'],
            ]);
        }

        return response()->json([
            "success" => "le bon ".$bon->ref."est Modifier avec success - ".$request->colis
        ]);        
    }




}
