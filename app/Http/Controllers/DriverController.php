<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\Hash;
use App\Models\User;



class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Data = Driver::with("user")->get();


        $formattedData = $Data->map(function ($Dt) {
            return [
                'id' => $Dt->id,
                'Nom' => $Dt->user->name,
                'Email' => $Dt->user->email,
                'Téléphone' => $Dt->user->phone,
            ];
        });


        return response()->json([ "data"=>$formattedData]);

    }


    

    public function get_deliveryman($id)
    {
        $Data = Driver::with('user')->find($id);

        if (!$Data) {
            return response()->json(['error' => 'Livreur pas trouver'], 404);
        }

        $formattedData = [
                'Nom' => $Data->user->name,
                'Email' => $Data->user->email,
                'Téléphone' => $Data->user->phone,
                'Adresse' => $Data->user->adress,
                'ICE' => $Data->ice,
                'Ville' => $Data->city_id,
                'Véhicule' => $Data->car_id,
                'Prix' => $Data->price_per_order,
                'MotdePasse' => $Data->user->password,
            ];

        return response()->json([ "data"=>$formattedData]);

    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new_deliveryman(Request $request)
    {
        
        $request->validate([
            'Nom' => 'required|max:50',
            'Téléphone' => 'required',
            'Adresse' => 'max:150',
            'Email' => 'required|email|unique:users',
            'MotdePasse' => 'required|min:6',
            "Prix" => 'required|numeric',
            "Ville" => "required|exists:cities,id",
            "Véhicule" => "required|exists:cars,id",
            "ICE" => "max:30",
            "Profile" => "max:150",
        ]);



        $user = User::create([
            'email' => $request->Email,
            'phone' => $request->Téléphone,
            'password' => Hash::make($request->MotdePasse),
            'name' => $request->Nom,
            'adress' => $request->Adresse,
            "role_id" => 32346,
            "profile_img" => $request->Profile,
        ]);


        Driver::create([
            'user_id' => $user->id,
            'profile_img' => "https://via.placeholder.com/300",
            'ice' => $request->ICE,
            'price_per_order' => $request->Prix,
            'ice' => $request->ICE,
            'city_id' => $request->Ville,
            'car_id' => $request->Véhicule,
        ]);
        
        return response()->json([
            "success" => "le Livreur est ajouter avec success"
        ]);        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_deliveryman(Request $request,$id)
    {

        $validatedData = $request->validate([
            'Nom' => 'required|max:50',
            'Téléphone' => 'required|numeric',
            'Adresse' => 'max:150',
            'Email' => 'required|email',
            'MotdePasse' => 'sometimes|nullable|min:6',
            'Prix' => 'required|numeric',
            "Ville" => "required|exists:cities,id",
            "Véhicule" => "required|exists:cars,id",
            'ICE' => 'max:50',
        ]);

        //check customer if exists
        $deliveryman = Driver::find($id);
        if (!$deliveryman) {
            return response()->json([
                "error" => "Livreur Pas de trauver"
            ]);  
        }

        //check user if exists
        $user = User::find($deliveryman->user_id);
        if (!$user) {
            return response()->json([
                "error" => "utilisateur Pas de trauver"
            ]);  
        }


        if (isset($validatedData['MotdePasse'])) {
            $validatedData['MotdePasse'] = Hash::make($validatedData['MotdePasse']);
        }

               //update user
        $user->update([
            'name' => $request->Nom,
            'email' => $request->Email,
            'phone' => $request->Téléphone,
            'profile_img' => $request->Profile,
            'password' => $validatedData['MotdePasse'],
        ]);

               //update customer
        $deliveryman->update([
            'user_id' => $user->id,
            'city_id' => $request->Ville,
            'car_id' => $request->Véhicule,
            'price_per_order' => $request->Prix,
            'ice' => $request->ICE,
        ]);
    
        return response()->json([
            "success" => "les informations du Livreur est Modifier avec success"
        ]);  

    }



    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->delete();
        return redirect()->route('drivers.index')->with('success', 'Driver has been deleted successfully!');
    }

}
    