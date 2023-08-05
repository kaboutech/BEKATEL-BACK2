<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\CitiesCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the cities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::with("CitiesCode")->get();

        $formatted_cities = $cities->map(function ($city) {
            return [
                'Nom' => $city->name,
                'Duree' => $city->delay,
                'id' => $city->id,
                'Prix' => $city->price,
                'Code' => $city->CitiesCode->name,
            ];
        });


        return response()->json([ "data"=>$formatted_cities]);
    }


    public function new_city(Request $request)
    {
        
        $request->validate([
            'Nom' => 'required',
            'Duree' => 'required',
            'Prix' => 'required',
            'Code' => 'required',
        ]);

        $Data = City::create([
            'name' => $request->Nom,
            'delay' => $request->Duree,
            'price' => $request->Prix,
            'cities_codes_id' => $request->Code,
        ]);
        
        return response()->json([
            "success" => "la Ville est ajouter avec success"
        ]);        
    }


    public function update_city(Request $request, $id)
    {
        $validatedData = $request->validate([
            'Nom' => 'required',
            'Duree' => 'required',
            'Prix' => 'required',
            'Code' => 'required',
        ]);

      
        //check user if exists
        $Data = City::find($id);
        if (!$Data) {
            return response()->json([
                "error" => "la ville Pas de trauver"
            ]);  
        }

        $Data->update([
            'name' => $request->Nom,
            'delay' => $request->Duree,
            'price' => $request->Prix,
            'cities_codes_id' => $request->Code,
        ]);
    
        return response()->json([
            "success" => "les informations de la Ville est Modifier avec success"
        ]);  

    }

    /**
     * Remove the specified city from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return redirect()->route('cities.index');
    }
}