<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expenses::all();

        $formatted_expenses = $expenses->map(function ($expense) {
            return [
                'id' => $expense->id,
                'ref' => $expense->ref,
                'Type' => $expense->expenses_type_id,
                'Montant' => $expense->amount,
                'Commentaire' => $expense->comment,

            ];
        });


        return response()->json([ "data"=>$formatted_expenses]);
    }


    public function get_expense($id)
    {
        $Data = Expenses::find($id);

        if (!$Data) {
            return response()->json(['error' => 'Expense pas trouver'], 404);
        }

        $formattedData = [
                'Type' => $Data->expenses_type_id,
                'Montant' => $Data->amount,
                'Commentaire' => $Data->comment,
            ];

        return response()->json([ "data"=>$formattedData]);

    }


    public function new_expense(Request $request)
    {
        
        $request->validate([
            'Type' => 'required',
            'Montant' => 'required',
            'Commentaire' => 'required',
        ]);

        $expense = Expenses::create([
            'comment' => $request->Commentaire,
            'amount' => $request->Montant,
            'expenses_type_id' => $request->Type,
        ]);
        
        return response()->json([
            "success" => "l'expense est ajouter avec success"
        ]);        
    }


    public function update_expense(Request $request,$id)
    {

        $validatedData = $request->validate([
            'Type' => 'required',
            'Montant' => 'required',
            'Commentaire' => 'required',
        ]);

      
        //check user if exists
        $expense = Expenses::find($id);
        if (!$expense) {
            return response()->json([
                "error" => "l'expense Pas de trauver"
            ]);  
        }

        $expense->update([
            'expenses_type_id' => $request->Type,
            'amount' => $request->Montant,
            'comment' => $request->Commentaire,
        ]);
    
        return response()->json([
            "success" => "les informations d'expenses est Modifier avec success"
        ]);  

    }

   
}
