<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solo;

class SoloController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Solo::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|string|unique:solos,tipo|max:45',
        ]);

        $solo = Solo::create($validated);

        return response()->json($solo, 201);    
    }

    /**
     * Display the specified resource.
     */
    public function show(Solo $solo)
    {
        return response()->json($solo);    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Solo $solo)
    {
        $validated = $request->validate([
            'tipo' => 'required|string|unique:solos,tipo,' . $solo->id . '|max:45',
        ]);

        $solo->update($validated);

        return response()->json($solo);    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Solo $solo)
    {
        try {
            $solo->delete();
            return response()->json(null, 204);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'message' => 'Não é possível deletar. Existem plantas vinculadas a este tipo de solo.'
            ], 409);
        }  
    
    }
}
