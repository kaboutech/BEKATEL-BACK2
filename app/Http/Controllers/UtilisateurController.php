<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UtilisateurController extends Controller
{

    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);
    
            return response()->json([
                'token' => $token,
                'name' => $user->name,
                'R_order_status' => $user->role_id,
            ]);
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }

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
        ]);
    
        $token = JWTAuth::fromSubject($user);
    
        return response()->json([
            'token' => $token,
            'name' => $request->name,
        ]);        
    }

    

    public function index()
    {
        $users = User::whereNotIn("role_id",[64319,32346])->get();

        $formattedusers = $users->map(function ($user) {
            return [
                'Nom' => $user->name,
                'E-mail' => $user->email,
                'Téléphone' => $user->phone,
            ];
        });


        return response()->json([ "data"=>$formattedusers]);

    }



    public function get_user($id)
    {
        $Data = User::find($id);

        if (!$Data) {
            return response()->json(['error' => 'Utilisateur pas trouver'], 404);
        }

        $formattedData = [
                'Nom' => $Data->name,
                'Email' => $Data->email,
                'Téléphone' => $Data->phone,
                'Adresse' => $Data->adress,
                'MotdePasse' => $Data->password,
                'Role' => $Data->role_id,
                'Profile' => $Data->profile_img,
            ];

        return response()->json([ "data"=>$formattedData]);

    }

   
       /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new_user(Request $request)
    {
        
        $request->validate([
            'Nom' => 'required|max:50',
            'Téléphone' => 'required',
            'Adresse' => 'max:150',
            'Email' => 'required|email|unique:users',
            'MotdePasse' => 'required|min:6',
            'Role' => 'required|exists:roles,id',
            'Profile' => 'max:150',
        ]);

        $user = User::create([
            'email' => $request->Email,
            'phone' => $request->Téléphone,
            'password' => Hash::make($request->MotdePasse),
            'name' => $request->Nom,
            'adress' => $request->Adresse,
            "profile_img" => $request->Profile,
            "role_id" => $request->Role,
        ]);


     
        
        return response()->json([
            "success" => "l'utilisateur est ajouter avec success"
        ]);        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_user (Request $request,$id)
    {

        $validatedData = $request->validate([
            'Nom' => 'required|max:50',
            'Téléphone' => 'required|numeric',
            'Adresse' => 'max:150',
            'Email' => 'required|email',
            'MotdePasse' => 'sometimes|nullable|min:6',
            'Profile' => 'max:80',
            'ICE' => 'max:50',
        ]);

        //check customer if exists
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                "error" => "Client Pas de trauver"
            ]);  
        }


        if (isset($validatedData['MotdePasse'])) {
            $validatedData['MotdePasse'] = Hash::make($validatedData['MotdePasse']);
        }

               //update user
        $user->update([
            'name' => $request->Nom,
            'email' => $request->Email,
            'adress' => $request->Adresse,
            'phone' => $request->Téléphone,
            'role_id' => $request->Role,
            'password' => $validatedData['MotdePasse'],
        ]);

       
    
        return response()->json([
            "success" => "les informations du client est Modifier avec success"
        ]);  

    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }


}
