<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planta;
use App\Models\Log;
use App\Http\Controller\LogController;

class PlantaController
{
    /*
     * Display a listing of the resource.
     */
    public function index()
    {
        $plantas = Planta::with('solo')->where('owner', auth()->id())->get();
        return response()->json($plantas);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function storeLog(Request $request)
    {
        $validated = $request->validate([
            'sensor_key' => 'required|string', 
            'estado' => 'required|integer|min:0|max:100', 
        ]);
        
        $planta = Planta::where('sensor_key', $validated['sensor_key'])->first();
        
        if (! $planta) {
        return response()->json(['error' => 'Sensor não autorizado'], 401);
        }

        $log = Log::create([
            'plantas_id' => $planta->id,         
            'estado' => $validated['estado'], 
        ]);
        
        $planta->update(['umidade' => $validated['estado']]);

        return response()->json([
            'message' => 'Log de umidade registrado com sucesso.',
            'log_id' => $log->id,
            'planta_nome' => $planta->nome_planta
        ], 201);
    }

    public function storePlanta(Request $request)
    {
        $validated = $request->validate([
            'nome_planta' => 'required|string|max:45',
            'sensor_key' => 'required|string|unique:plantas,sensor_key', 
            'solo_id' => 'required|integer|exists:solos,id',
            'umidade' => 'nullable|integer|min:0|max:100',
            'umidade_minima' => 'nullable|integer|min:0|max:100',
        ]);  
        
        $validated['owner'] = auth()->id();

        $planta = Planta::create($validated);
        
        return response()->json([
            'message' => 'Planta/Sensor cadastrado com sucesso.',
            'planta' => $planta], 201);  
    }        


    /**
     * Display the specified resource.
     */
    public function show(Planta $planta)
    {

        abort_if($planta->owner !== auth()->id(), 403);
        $planta->load(['solo', 'logs' => function ($query) {
            $query->latest('created_at'); 
        }]);

        return response()->json($planta);    
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePlanta(Request $request, Planta $planta)
    {
        abort_if($planta->owner !== auth()->id(), 403);

        $validated = $request->validate([
            'nome_planta' => 'sometimes|string|max:45',
            'sensor_key' => 'sometimes|string|unique:plantas,sensor_key,' . $planta->id, 
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
    public function destroyPlanta(Planta $planta)
    {
        abort_if($planta->owner !== auth()->id(), 403);
        $planta->delete();

        return response()->json([
            'message' => 'Planta excluída com sucesso'
        ], 200);

    }
}
