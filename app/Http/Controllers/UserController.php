<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class UserController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
        User::select('id', 'nome', 'email')->get()
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function logout(Request $request)
    {
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Logout realizado com sucesso.']);
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

        $token = $user->createToken('app_token')->plainTextToken;
        
        return response()->json([
            'message' => 'Login bem-sucedido.',
            'user' => $user->only(['id', 'nome', 'email']),
            'token' => $token,
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
        $token = $user->createToken('app_token')->plainTextToken;

        return response()->json(['user' => $user->only(['id', 'nome', 'email']),
                                'token'=>$token], 201);        
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json($user->only(['id', 'nome', 'email']));
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
