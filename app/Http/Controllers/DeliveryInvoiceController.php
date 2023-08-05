<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryInvoice;

class DeliveryInvoiceController extends Controller
{
    
    public function index()
    {
        $deliveryinvoices = DeliveryInvoice::all();

        $formatted_deliveryinvoices = $deliveryinvoices->map(function ($invoice) {
            return [
                'id' => $invoice->id,
                'Ref' => $invoice->ref,
                'Cloturé' => $invoice->closed,
                'Versé' => $invoice->paid,
                'Montant' => $invoice->amount,
                'Colis' => $invoice->orders,
                'Livreur' => $invoice->driver_id,
            ];
        });


        return response()->json([ "data"=>$formatted_deliveryinvoices]);

    }


    public function update_delivery_invoice_close(Request $request,$id)
    {

        $validatedData = $request->validate([
            'Cloturé' => 'required|max:1|min:0',
        ]);

        $invoice = DeliveryInvoice::find($id);

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

    public function update_delivery_invoice_paid(Request $request,$id)
    {

        $validatedData = $request->validate([
            'Versé' => 'required|max:1|min:0',
        ]);

        $invoice = DeliveryInvoice::find($id);

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
