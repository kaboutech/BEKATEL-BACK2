<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;

use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{

    public function register(Request $request)
    {
     
        $request->validate([
            'email' => 'required|unique:users',
            'password' => 'required|max:40',
            'name' => 'required|max:40',
        ]);


        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            "role_id" => 64319
        ]);
    
        $token = JWTAuth::fromSubject($user);
    
        return response()->json([
            'token' => $token,
            'name' => $request->name,
            "R_order_status" => 64319
        ]);        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::with("user")->get();

        $formattedCustomers = $customers->map(function ($ct) {
            return [
                'id' => $ct->id,
                'Nom' => $ct->user->name,
                'E-mail' => $ct->user->email,
                'Téléphone' => $ct->user->phone,
            ];
        });


        return response()->json([ "data"=>$formattedCustomers]);

    }

    public function get_customer($id)
    {
        $Data = Customer::with('user')->find($id);

        if (!$Data) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $formattedData = [
                'Nom' => $Data->user->name,
                'Email' => $Data->user->email,
                'Téléphone' => $Data->user->phone,
                'Adresse' => $Data->user->adress,
                'ICE' => $Data->ice,
                'IF' => $Data->if,
                'Nom_Societe' => $Data->company_name,
                'Logo' => $Data->company_logo,
                'MotdePasse' => $Data->user->password,
            ];

        return response()->json([ "data"=>$formattedData]);

    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new_customer(Request $request)
    {
        
        $request->validate([
            'email' => 'required|unique:users',
            'password' => 'required|max:40',
            'name' => 'required|max:40',
            'company_name' => 'max:50',
            'company_logo' => 'max:150',
        ]);

     /*   $validatedData = $request->validate([
            'name' => 'required|max:50',
            'phone' => 'required|numeric',
            'email' => 'required|email|unique:customers',
            'password' => 'required|min:6',
            'company_name' => 'max:80',
            'company_logo' => 'max:80',
            'If' => 'max:50',
            'Ice' => 'max:100',
        ]);
        */


        $user = User::create([
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'adress' => $request->adress,
            "role_id" => 64319
        ]);


        Customer::create([
            'user_id' => $user->id,
            'company_name' => $request->company_name,
            'company_logo' => "https://via.placeholder.com/300",
            'if' => $request->ifs,
            'ice' => $request->ice,
        ]);
        
        return response()->json([
            "success" => "le client est ajouter avec success"
        ]);        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_customer(Request $request,$id)
    {

        $validatedData = $request->validate([
            'Nom' => 'required|max:50',
            'Téléphone' => 'required|numeric',
            'Adresse' => 'max:150',
            'Email' => 'required|email',
            'MotdePasse' => 'sometimes|nullable|min:6',
            'Nom_Societe' => 'max:80',
            'IF' => 'max:50',
            'ICE' => 'max:50',
        ]);

        //check customer if exists
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json([
                "error" => "Client Pas de trauver"
            ]);  
        }

        //check user if exists
        $user = User::find($customer->user_id);
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
            'password' => $validatedData['MotdePasse'],
        ]);

               //update customer
        $customer->update([
            'company_name' => $request->Nom_Societe,
            'if' => $request->IF,
            'ice' => $request->ICE,
        ]);
    
        return response()->json([
            "success" => "les informations du client est Modifier avec success"
        ]);  

    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully');
    }

}