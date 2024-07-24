<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()//affiche tous les utilisateurs
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)//créé un nouvel utilisateur
    {
         $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id|not_in:1',//1 est le status d'admin
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3|confirmed',
            'password_confirmation' => 'required|string|min:3',
            'avatar' => 'nullable|string',
        ]);

        // Si la validation échoue, retourner une réponse avec les erreurs
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Création de l'utilisateur
        // $role = roles::create([

        // ]);
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'role_id' => $request->role_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $request->avatar,
        ]);

        // Retourner une réponse JSON avec les informations de l'utilisateur créé
        return response()->json($user, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(roles $roles)//Pour se log
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(roles $roles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, roles $roles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(roles $roles)
    {
        //
    }
}
