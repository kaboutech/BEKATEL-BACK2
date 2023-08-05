<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Product;
use App\Models\Receiver;
use App\Models\OrderStatus;
use App\Models\OrderItemsPickup;
use Illuminate\Support\Facades\Auth;




use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $user=Auth::user();
        $roleId = $user->role_id;
        $userId = $user->id;

        $query = Order::with('customer', 'driver', 'receiver', 'orderStatus');

        if ($roleId == 32346) {
            // If the role is driver, show orders related to the driver_id
            $query->where('driver_id', Driver::where("user_id",$userId)->value("id"));
        } elseif ($roleId == 64319) {
            // If the role is customer, show orders related to the customer_id
            $query->where('customer_id', Customer::where("user_id",$userId)->value("id"));
        }
        //get data for specific role
        $Data = $query->get();

        $formattedData = $Data->map(function ($dt) use ($roleId){
            $Driver="No-Livreur";
            //check if driver has selected/exists
            if($dt->driver_id) $Driver=$dt->driver->user->name;

            
           // Add additional fields based on the user's role
    $extraFields = [];

    if($roleId!=32346 && $roleId!=64319){
        $extraFields = [
            'Client' => $dt->customer->user->name,
            'Livreur' => $Driver,
        ];
    }

    return [
        'id' => $dt->id,
        'Ref' => $dt->ref,
        'Statut' => $dt->orderStatus->name,
        'Adresse' => $dt->receiver->adresse,
        'Ville' => $dt->receiver->city->name,
        'Montant' => $dt->amount,
    ] + $extraFields;

        });
        return response()->json([ "data"=>$formattedData]);
    
    }

    public function orders_for_bons()
    {
        $Data = Order::with('Receiver','OrderStatus','Customer')->get();


    $formattedData = $Data->map(function ($dt) {
        return [
            'id' => $dt->id,
            'Ref' => $dt->ref,
            'Statut' => $dt->OrderStatus->name,
            'Client' => $dt->customer->user->name,
            'Adresse' => $dt->Receiver->adresse,
            'Montant' => $dt->amount,
        ];
    });
    return response()->json([ "data"=>$formattedData]);

    }

    public function new_order(Request $request)
    {
        $request->validate([
            "Ref" => "max:30",
            "Nom" => "required",
            "Téléphone" => "required",
            "Email" => "email",
            "Ville" => "required",
            "Adresse" => "required",
            "Commentaire" => "max:150",
            "si_Stock" => "required",
            "PrixTotal" => "required",
            "ouvrir_colis" => "required", 
        ]);


        //customer
        $user = Auth::user();
        if($user->role_id==64319){
            if($request->ClientID) return response()->json([ "error" => "vous n'avez pas l'access a cette resource" ]);  
            $customer_id=Customer::where("user_id",$user->id)->value("id");
        }else $customer_id=$request->ClientID;
        

        

        //Order Details


        if($request->Ref){
            $uniqueId=$request->Ref;
        }else{
            $prefix = 'CMD-';
            $uniqueId = $prefix . uniqid();
        }
        

        $Receiver = Receiver::create([
            'adresse' => $request->Adresse,
            'name' => $request->Nom,
            'phone' => $request->Téléphone,
            'email' => $request->Email,
            'city_id' => $request->Ville,
        ]);

        $Order = Order::create([
            'ref' => $uniqueId,
            'amount' => $request->PrixTotal,
            'customer_id' => $customer_id,
            'from_stock' => $request->si_Stock,
            'order_status_id' => 6,
            'receiver_id' => $Receiver->id,
            'open_package' => $Receiver->ouvrir_colis,
        ]);


        //product details

        if($request->si_Stock){
            $request->validate([
                "selectedProducts" => "required|array",
            ]);    

            foreach ($request->selectedProducts as $row) {
                OrderItem::create([
                    'order_id' => $Order->id,
                    'product_id' => $row['id'],
                    'quantity	' => $row['Quantite'],
                ]);
            }
            
        }else{
            $request->validate([
                "TitresProduits" => "required",
                "TypeProduit" => "max:10",
                "CategorieProduit" => "max:10",
                "ProduitQuantite" => "max:10",
            ]);    

            $Order = OrderItemsPickup::create([
                'name' => $request->TitresProduits,
                'product_type_id' => $request->TypeProduit,
                'product_categorie_id' => $request->CategorieProduit,
                'quantity' => $request->ProduitQuantite,
                'order_id' => $Order->id,
            ]);

            
        }

        return response()->json([
            "success" => "la Commande est ajouter avec success".$uniqueId
        ]);        
    }



    public function get_order($id)
    {
        $Data = Order::with('customer', 'driver', 'receiver', 'orderStatus')->find($id);

        if (!$Data) {
            return response()->json(['error' => 'La commande est pas trouver'], 404);
        }

        //check if driver has selected/exists
        $Driver="No-Livreur";
        if($Data->driver_id) $Driver=$Data->driver->user->name;
        $formattedDataProducts = [];
        if ($Data->from_stock) {
            $items=OrderItem::with("product")->where("order_id",$id)->get();
            $formattedDataProducts = $items->map(function ($dt) {
                return[
                'Nom' => $dt->product->name,
                'Quantite' => $dt->quantity,
                'Type' => $dt->product->product_type->name,
                'Image' => $dt->product->image,
                ];
            }); 
        }else{
            $items=OrderItemsPickup::with("product_type")->where("order_id",$id)->get();
           
            $formattedDataProducts = $items->map(function ($dt) {
                return[
                    'Nom' => $dt->name,
                    'Quantite' => $dt->quantity,
                    'Type' => $dt->product_type->name,
                    'Image' => $dt->image,
                ];
            });
        }

        $Data = Order::with('customer', 'driver', 'receiver', 'orderStatus')->find($id);

        $formattedData = [
            'Ref' => $Data->ref,
            'id' => $Data->id,
            'Client' => $Data->customer->user->name,
            'Montant' => $Data->amount, 
            'Adresse' => $Data->receiver->adresse,
            'Nom' => $Data->receiver->name,
            'Téléphone' => $Data->receiver->phone,
            'Email' => $Data->receiver->email,
            'Ville' => $Data->receiver->city->name,
            'Livreur' => $Driver,
            'Si_Stock' => $Data->from_stock,
            'ouvrir_colis' => $Data->open_package, 
            "products" => $formattedDataProducts,

        ];

        return response()->json([ "data"=>$formattedData]);

    }





   
   
}

    
               
