<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()//affiche tous les utilisateurs
    {
        $users = User::all();
        Log::info('Alerte générale, quelqu\'un consulte la liste des users !!!!!!!.');//Ajouter un log telescope
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
    public function show($id)//Pour se log
    {
        $user = User::find($id);
        if($user)
            return response()->json($user, 200);

        return response()->json(["error" => "Missing user"], 404);
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
    public function update($id, Request $request)
    {
        $user = User::find($id);
        if (!$user)
            return response()->json(['error' => 'Missing user'], 404);

        $validator = Validator::make($request->all(), [
            'firstname' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'role_id' => 'nullable|exists:roles,id|not_in:3',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:3|confirmed',
            'password_confirmation' => 'nullable|required_with:password|string|min:3',
            'avatar' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user->update($request->only([
            'firstname',
            'lastname',
            'role_id',
            'email',
            'avatar',
        ]));
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }
        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user)
            return response()->json(['error' => 'Missing user'], 404);

        $authUser = auth()->user();
        if ($authUser->id != $id && $authUser->role_id !== 1)
            return response()->json(['error' => 'Unauthorized action : user '.$authUser->id.' (role '.$authUser->role_id.') can\'t delete user '.$user->id], 403);
        
        $user->delete();
        return response()->json(['confirm' => 'User deleted'], 200);
    }
}
