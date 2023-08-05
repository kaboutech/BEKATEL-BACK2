<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use App\Models\OrderPhase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    public function index()
    {
        $OrderStatus = OrderStatus::with("order_phase")->get();

        $formatted_OrderStatus = $OrderStatus->map(function ($OrderStatu) {
            return [
                'id' => $OrderStatu->id,
                'Nom' => $OrderStatu->name,
                'Coleur' => $OrderStatu->color,
                'Phase' => $OrderStatu->order_phase->name,
            ];
        });
        return response()->json([ "data"=>$formatted_OrderStatus]);
    }

  
    


    public function get_order_status($id)
    {
        $Data = OrderStatus::with("OrderPhase")->find($id);

        if (!$Data) {
            return response()->json(['error' => 'le statut pas trouver'], 404);
        }

        $formattedData = [
            'id' => $OrderStatu->id,
            'Nom' => $OrderStatu->name,
            'Coleur' => $OrderStatu->color,
            'Phase' => $OrderStatu->orderPhase->name,
            ];

        return response()->json([ "data"=>$formattedData]);

    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new_order_status(Request $request)
    {
        
        $request->validate([
            'Nom' => 'required',
            'Coleur' => 'required',
            'Phase' => 'required',
        ]);

        $user = OrderStatus::create([
            'name' => $request->Nom,
            'color' => $request->Coleur,
            'order_phases_id' => $request->Phase,
        ]);
        
        return response()->json([
            "success" => "le Statut est ajouter avec success"
        ]);        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_order_status(Request $request,$id)
    {

        $validatedData = $request->validate([
            'Nom' => 'required',
            'Coleur' => 'required',
            'Phase' => 'required',
        ]);

      
        //check user if exists
        $Package = OrderStatus::find($id);
        if (!$Package) {
            return response()->json([
                "error" => "le Statut Pas de trauver"
            ]);  
        }


    

               //update user
        $Package->update([
            'name' => $request->Nom,
            'color' => $request->Coleur,
            'order_phases_id' => $request->Phase,
        ]);
    
        return response()->json([
            "success" => "les informations du Statut est Modifier avec success"
        ]);  

    }


}