<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserItemRequest;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login(AuthRequest $request){
        $validated = $request->validated();
        $user = User::where('email', $validated['email'])->first();

        if(!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Credentials not found.'], 401);
        }

        return response([
            'user' => $user,
            'token' => $user->createToken($validated['email'])->plainTextToken
        ]);
    }
    
    
    public function logout() {
        Auth::user()->tokens()->delete();
        return ['message' => 'Logout successfully.'];
    }
}
