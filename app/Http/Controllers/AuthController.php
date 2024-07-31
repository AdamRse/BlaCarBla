<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            Log::info('Un utilisateur s\'est connecté.', ['user_id' => auth()->user()->id]);//Ajouter un log telescope
            return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
        } else {
            return response()->json(['message' => 'Invalid login details'], 401);
        }
    }
}
