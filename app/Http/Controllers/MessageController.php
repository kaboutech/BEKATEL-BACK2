<?php

namespace App\Http\Controllers;

use App\Events\NewMessageEvent;
use App\Models\Message;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::all();

        $formatted_messages = $messages->map(function ($message) {
            return [
                'si_client' => $message->is_customer,
                'Date' => $message->date,
                'Contenu' => $message->content,
                'Utilisateur' => $message->user_id,

            ];
        });
        return response()->json([ "data"=>$formatted_messages]);
    }


    public function new_message(Request $request)
    {

         //customer
         $si_client=0;
         $user = Auth::user();
         if($user->role_id==64319){
             $si_client=1;
         }
        
         

        $request->validate([
            'Message' => 'required',
            'ConversationId' => 'required',
        ]);

        $message = Message::create([
            'content' => $request->Message,
            'conversation_id' => $request->ConversationId,
            'user_id' => $user->id,
            'is_customer' =>  $si_client,

        ]);

// Broadcast the event
event(new NewMessageEvent($message));
        
        return response()->json([
            "success" => "Votre Ticket est ajouter avec success"
        ]);        
    }

}
