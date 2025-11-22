<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planta;

class PlantaController
{
    /*
     * Display a listing of the resource.
     */
    public function index()
    {

        $plantas = Planta::with('solo')->get();
        return response()->json($plantas);    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function storePlanta(Request $request)
    {
        $validated = $request->validate([
            'nome_planta' => 'required|string|max:45',
            'sensor_key' => 'required|string|unique:plantas,sensor_key', 
            'solo_id' => 'required|integer|exists:solos,id',
            'umidade' => 'nullable|integer|min:0|max:100',
        ]);  
        
        $planta = Planta::create($validated);
        
        return response()->json([
            'message' => 'Planta/Sensor cadastrado com sucesso.',
            'planta' => $planta], 201);  
    }        


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function updatePlanta(Request $request, string $id)
    {
        abort_if($planta->user_id !== auth()->id(), 403, 'Acesso não autorizado a esta planta.');

        $validated = $request->validate([
            'nome_planta' => 'sometimes|string|max:45',
            'sensor_key' => 'sometimes|string|unique:plantas,sensor_key,' . $planta->id, 
            'solo_id' => 'sometimes|integer|exists:solos,id',
        ]);
        
        $planta->update($validated);
        
        return response()->json([
            'message' => 'Planta atualizada com sucesso.',
            'planta' => $planta
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyPlanta(string $id)
    {
        abort_if($planta->user_id !== auth()->id(), 403, 'Acesso não autorizado a esta planta.');

        $planta->delete();

        return response()->json(null, 204);
    }
}
