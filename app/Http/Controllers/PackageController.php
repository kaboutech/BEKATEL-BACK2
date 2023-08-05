<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::all();

        $formatted_packages = $packages->map(function ($package) {
            return [
                'Ref' => $package->ref,
                'id' => $package->id,
                'Nom' => $package->name,
                'Prix' => $package->price,
                'Img' => $package->image,
            ];
        });


        return response()->json([ "data"=>$formatted_packages]);
    }

    

    public function get_package($id)
    {
        $Data = Package::find($id);

        if (!$Data) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $formattedData = [
                'id' => $Data->id,
                'ref' => $Data->ref,
                'Titre' => $Data->name,
                'Quantite' => $Data->quantity,
                'Image' => $Data->image,
                'Prix' => $Data->price,
            ];

        return response()->json([ "data"=>$formattedData]);

    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new_package(Request $request)
    {
        
        $request->validate([
            'Titre' => 'required',
            'Quantite' => 'required',
            'Image' => 'max:150',
            'Prix' => 'required',
        ]);

        $user = Package::create([
            'name' => $request->Titre,
            'quantity' => $request->Quantite,
            'image' => $request->Image,
            'price' => $request->Prix,
        ]);
        
        return response()->json([
            "success" => "l'embalage est ajouter avec success"
        ]);        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_package(Request $request,$id)
    {

        $validatedData = $request->validate([
            'Titre' => 'required',
            'Quantite' => 'required',
            'Image' => 'max:150',
            'Prix' => 'required',
        ]);

      
        //check user if exists
        $Package = Package::find($id);
        if (!$Package) {
            return response()->json([
                "error" => "l'embalage Pas de trauver"
            ]);  
        }


    

               //update user
        $Package->update([
            'name' => $request->Titre,
            'quantity' => $request->Quantite,
            'image' => $request->Image,
            'price' => $request->Prix,
        ]);
    
        return response()->json([
            "success" => "les informations d'embalage est Modifier avec success"
        ]);  

    }


}
