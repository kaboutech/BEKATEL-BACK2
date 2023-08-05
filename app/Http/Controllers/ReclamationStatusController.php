<?php

namespace App\Http\Controllers;

use App\Models\ReclamationStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReclamationStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ReclamationStatus = ReclamationStatus::all();

        $formatted_ReclamationStatus = $ReclamationStatus->map(function ($ReclamationStatu) {
            return [
                'Nom' => $ReclamationStatu->name,
                'Couleur' => $ReclamationStatu->color,
            ];
        });
        return response()->json([ "data"=>$formatted_ReclamationStatus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reclamationStatuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:20'
        ]);

        $reclamationStatus = ReclamationStatus::create($validatedData);

        return redirect()->route('reclamationStatuses.show', $reclamationStatus->id)->with('success', 'Reclamation status created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reclamationStatus = ReclamationStatus::find($id);
        return view('reclamationStatuses.show', compact('reclamationStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reclamationStatus = ReclamationStatus::find($id);
        return view('reclamationStatuses.edit', compact('reclamationStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:20'
        ]);

        ReclamationStatus::whereId($id)->update($validatedData);

        return redirect()->route('reclamationStatuses.show', $id)->with('success', 'Reclamation status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reclamationStatus = ReclamationStatus::find($id);
        $reclamationStatus->delete();
        return redirect()->route('reclamationStatuses.index')->with('success', 'Reclamation status deleted successfully.');
    }
}