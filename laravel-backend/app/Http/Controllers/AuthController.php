<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => 'Nieprawidłowe dane logowania'], 400);
        }
    
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token');

            return response()->json(['message' => 'Zalogowano pomyślnie', 'user' => $user, 'token' => $token], 200);
        } else {
            return response()->json(['error' => 'Nieprawidłowe dane logowania'], 400);
        }
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'date_of_birth' => 'required|date',
            'country' => 'required|string',
            'postal_code' => 'required|string',
            'city' => 'required|string',
            'street' => 'required|string',
            'apartment' => 'nullable|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
    
        $existingUser = User::where('email', $data['email'])->first();
    
        if ($existingUser) {
            return response()->json(['message' => 'Użytkownik o tym adresie email już istnieje.'], 400);
        }
    
        $data['password'] = Hash::make($data['password']);
    
        $user = User::create($data);

        return response()->json(['message' => 'Konto zostało utworzone'], 200);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return response()->json(['message'=> 'Logged out'], 200);
    }
}
