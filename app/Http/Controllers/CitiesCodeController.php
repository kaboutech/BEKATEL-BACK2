<?php

namespace App\Http\Controllers;

use App\Models\CitiesCode;
use Illuminate\Http\Request;

class CitiesCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Data = CitiesCode::all();

        $formatted_Data = $Data->map(function ($dt) {
            return [
                'id' => $dt->id,
                'Nom' => $dt->name,
            ];
        });
        return response()->json([ "data"=>$formatted_Data]);
    }



    public function new_city_code(Request $request)
    {
        
        $request->validate([
            'Nom' => 'required',
        ]);

        $Data = CitiesCode::create([
            'name' => $request->Nom,
        ]);
        
        return response()->json([
            "success" => "le Code est ajouter avec success"
        ]);        
    }


    public function update_city_code(Request $request, $id)
    {
        $validatedData = $request->validate([
            'Nom' => 'required',
        ]);

      
        //check user if exists
        $Data = CitiesCode::find($id);
        if (!$Data) {
            return response()->json([
                "error" => "la ville Pas de trauver"
            ]);  
        }

        $Data->update([
            'name' => $request->Nom,
        ]);
    
        return response()->json([
            "success" => "les informations du Code est Modifier avec success"
        ]);  

    }



    

}