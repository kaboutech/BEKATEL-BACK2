<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ConversationController extends Controller
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

        $query = Conversation::with('customer');

        if ($roleId == 64319) {
            // If the role is customer, show orders related to the customer_id
            $query->where('customer_id', Customer::where("user_id",$userId)->value("id"));
        }

        // date from old to new
        $query->orderByDesc('updated_at');


// Add the date range condition here
//$startDate = '2023-07-01'; // Replace this with your start date
//$endDate = '2023-07-31';   // Replace this with your end date
//$query->whereBetween('updated_at', [Carbon::parse($startDate), Carbon::parse($endDate)->endOfDay()]);



        //get data for specific role
        $conversations = $query->get();

        $formatted_conversations = $conversations->map(function ($conversation) use ($roleId) {


            $Driver="No-Livreur";
            if($conversation->driver_id) $Driver=$conversation->driver->user->name;

            $extraFields = [];

            if($roleId!=32346 && $roleId!=64319){
                $extraFields = [
                    'Client' => $conversation->customer->user->name,
                    'Livreur' => $Driver,
                    'notification' => $conversation->admin_read,
                    'notification_count' => $conversation->admin_read_count,
                ];
            }else {
                $extraFields = [
                    'notification' => $conversation->customer_read,
                    'notification_count' =>  $conversation->customer_read_count,
                ];
            }

            return [
                'Client' => $conversation->customer->user->name,
                'Date' => $conversation->date,
                'Commande' => $conversation->order_id,
                'Date' => $conversation->updated_at,
                'Date' => $conversation->updated_at,

            ]+$extraFields;
        });


        return response()->json([ "data"=>$formatted_conversations]);
    }




    public function new_conversation(Request $request)
    {

        $request->validate([
            'CommandeID' => 'required|exists:orders,id',
        ]);

        $customer_id=Order::find($request->CommandeID)->customer_id;

        $conversation = Conversation::create([
            'customer_id' => $customer_id,
            'order_id' => $request->CommandeID,
            'admin_read' => 0,
            'admin_read_count' =>  0,
            'customer_read' => 0,
            'customer_read_count' => 0,
        ]);

        return response()->json([
            "success" => "Votre Conversation est ajouter avec success"
        ]);  
    }
}
