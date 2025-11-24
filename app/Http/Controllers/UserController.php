<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(User::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'senha' => 'required|string', 
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->senha, $user->senha)) {
            
            throw ValidationException::withMessages([
                'email' => ['Credenciais fornecidas estão incorretas.'],
            ]);
        }
        
        return response()->json([
            'message' => 'Login bem-sucedido.',
            'user' => $user->only(['id', 'nome', 'email'])
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|unique:users,email|max:255',
            'nome' => 'required|string|max:255',
            'senha' => 'required|string|min:5|max:255'

        ]);
        $validated['senha'] = Hash::make($validated['senha']);

        $user = User::create($validated);

        return response()->json($user->only(['id', 'nome', 'email']), 201);        
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json($user);        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, user $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        //
    }
}
