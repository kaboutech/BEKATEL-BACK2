<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
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

        $query = Product::with("customer","product_categorie","product_type","package");

        if ($roleId == 64319) {
            // If the role is customer, show orders related to the customer_id
            $query->where('customer_id', Customer::where("user_id",$user->id)->value("id"));
        }

        //get data for specific role
        $products = $query->get();


        

        $formatted_products = $products->map(function ($product) use ($roleId){

            $package_name="No-Embalage";
            if($product->package) $package_name=$product->package->name;

            $extraFields = [];
            if($roleId!=64319){
                $extraFields = [
                    'Client' => $product->customer->user->name,
                ];
            }

            return [
                'Ref' => $product->ref,
                'id' => $product->id,
                'Titre' => $product->name,

                'TypeID' => $product->product_type_id,
                'Type' => $product->product_type->name,

                'Categorie' => $product->product_categorie->name,
                'CategorieID' => $product->product_categorie_id,

                'Quantite' => $product->quantity,
                'img' => $product->image,

                'Embalage' => $package_name,

            ]+ $extraFields;
        });


        return response()->json([ "data"=>$formatted_products]);
    }

   


      

    public function get_product($id)
    {
        $Data = Product::find($id);

        if (!$Data) {
            return response()->json(['error' => 'Produit pas trouver'], 404);
        }

        $formattedData = [
            'Ref' => $Data->ref,
            'id' => $Data->id,
            'Titre' => $Data->name,
            'Poid' => $Data->weight,


            'TypeID' => $Data->product_type_id,

            'CategorieID' => $Data->product_categorie_id,

            'Quantite' => $Data->quantity,
            'img' => $Data->image,

            'ClientID' => $Data->customer_id,

            'si_Embalage' => $Data->is_package,
            'EmbalageID' => $Data->package_id,
            

            ];

        return response()->json([ "data"=>$formattedData]);

    }

  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new_product(Request $request)
    {
        
        $request->validate([
            'Titre' => 'required',
            'Poid' => 'required',
            'CategorieID' => 'required',
            'TypeID' => 'required',
            'EmbalageID' => 'max:100',
        ]);


         //customer
         $user = Auth::user();
         if($user->role_id==64319){
             if($request->ClientID) return response()->json([ "error" => "vous n'avez pas l'access a cette resource" ]);  
             $customer_id=Customer::where("user_id",$user->id)->value("id");
         }else $customer_id=$request->ClientID;

         

        $user = Product::create([
            'name' => $request->Titre,
            'weight' => $request->Poid,
            'image' => $request->Image,
            'customer_id' => $customer_id,
            'product_type_id' => $request->TypeID,
            'product_categorie_id' => $request->CategorieID,
            'package_id' => $request->EmbalageID,
            'is_package' => $request->si_Embalage,

        ]);
        
        return response()->json([
            "success" => "le Produit est ajouter avec success"
        ]);        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_product(Request $request,$id)
    {

        $validatedData = $request->validate([
            'Titre' => 'required',
            'Poid' => 'required',
            'CategorieID' => 'required',
            'TypeID' => 'required',
            'ClientID' => 'required',
            'EmbalageID' => 'max:100',
        ]);

      
        //check user if exists
        $Package = Product::find($id);
        if (!$Package) {
            return response()->json([
                "error" => "Produit Pas de trauver"
            ]);  
        }


    

               //update user
        $Package->update([
            'name' => $request->Titre,
            'weight' => $request->Poid,
            'image' => $request->Image,
            'customer_id' => $request->ClientID,
            'product_type_id' => $request->TypeID,
            'product_categorie_id' => $request->CategorieID,
            'package_id' => $request->EmbalageID,
            'is_package' => $request->si_Embalage,
        ]);
    
        return response()->json([
            "success" => "les informations du produit est Modifier avec success"
        ]);  

    }





  
}
