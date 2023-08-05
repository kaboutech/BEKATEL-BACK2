<?php

namespace App\Http\Controllers;

use App\Models\Reclamation;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReclamationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user=Auth::user();
        $roleId = $user->role_id;
        $userId = $user->id;

        $query = Reclamation::with("customer","reclamation_status");
        
        if ($roleId == 64319) {
            // If the role is customer, show orders related to the customer_id
            $query->where('customer_id', Customer::where("user_id",$userId)->value("id"));
        }
        
        //get data for specific role
        $reclamations = $query->get();


        $formatted_reclamations = $reclamations->map(function ($reclamation) {
            return [
                'id' => $reclamation->id,
                'Ref' => $reclamation->ref,
                'Client' => $reclamation->customer->user->customer_id,
                'Sujet' => $reclamation->title,
                'Statut' => $reclamation->reclamation_status->name,
                'Content' => $reclamation->content,
            ];
        });


        return response()->json([ "data"=>$formatted_reclamations]);
    }

    public function get_reclamation($id)
    {
        $Data = Reclamation::with("customer","reclamation_status")->find($id);

        if (!$Data) {
            return response()->json(['error' => 'Ticket pas trouver'], 404);
        }

        $formattedData = [
            'id' => $Data->id,
            "type" => $Data->reclamations_type_id,
             'Ref' => $Data->ref,
            'Client' => $Data->customer->user->customer_id,
            'Sujet' => $Data->title,
            'Statut' => $Data->reclamation_status->name,
            'Contenu' => $Data->content,
            ];

        return response()->json([ "data"=>$formattedData]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new_reclamation(Request $request)
    {


         //customer
         $user = Auth::user();
         if($user->role_id==64319){
             $customer_id=Customer::where("user_id",$user->id)->value("id");
         }else return response()->json([ "error" => "vous n'avez pas l'access a cette resource" ]);  
        
         

        $request->validate([
            'Type' => 'required',
            'Contenu' => 'required',
            'Sujet' => 'required',
        ]);

        $user = Reclamation::create([
            'ref' => 'T-'.uniqid(),
            'reclamations_type_id' => $request->Type,
            'reclamation_status_id' => 1,
            'content' => $request->Contenu,
            'title' => $request->Sujet,
            'customer_id' => $customer_id,

        ]);
        
        return response()->json([
            "success" => "Votre Ticket est ajouter avec success"
        ]);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_reclamation(Request $request,$id)
    {
        $validatedData = $request->validate([
            'Type' => 'required',
            'Contenu' => 'required',
            'Sujet' => 'required',
        ]);

      
        //check user if exists
        $reclamation = Reclamation::find($id);
        if (!$reclamation) {
            return response()->json([
                "error" => "Ticket Pas de trauver"
            ]);  
        }


    

               //update user
        $reclamation->update([
            'reclamations_type_id' => $request->Type,
            'content' => $request->Contenu,
            'title' => $request->Sujet,
        ]);
    
        return response()->json([
            "success" => "Ticket est Modifier avec success"
        ]);  

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reclamation  $reclamation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reclamation $reclamation)
    {
        //
    }
}
