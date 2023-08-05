<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerInvoice;

class CustomerInvoiceController extends Controller
{
    //
    public function index()
    {
        $users = CustomerInvoice::all();

        $formattedusers = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'Ref' => $user->ref,
                'Cloturé' => $user->closed,
                'Versé' => $user->paid,
                'Montant' => $user->amount,
                'Colis' => $user->orders,
                'Client' => $user->customer_id,
            ];
        });


        return response()->json([ "data"=>$formattedusers]);

    }


    public function update_customer_invoice_close(Request $request,$id)
    {

        $validatedData = $request->validate([
            'Cloturé' => 'required|max:1|min:0',
        ]);

        $invoice = CustomerInvoice::find($id);

        if (!$invoice) {
            return response()->json([
                "error" => "Facture Pas de trauver"
            ]);  
        }

        $invoice->update([
            'closed' => $request->Cloturé,
        ]);


        return response()->json([
            "success" => "la facture ".$invoice->ref." est bien Modifié"
        ]);  

    }

    public function update_customer_invoice_paid(Request $request,$id)
    {

        $validatedData = $request->validate([
            'Versé' => 'required|max:1|min:0',
        ]);

        $invoice = CustomerInvoice::find($id);

        if (!$invoice) {
            return response()->json([
                "error" => "Facture Pas de trauver"
            ]);  
        }

        $invoice->update([
            'paid' => $request->Versé,
        ]);


        return response()->json([
            "success" => "la facture ".$invoice->ref." est bien Modifié"
        ]);  

    }

    

    
}
