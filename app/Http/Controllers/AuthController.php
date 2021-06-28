<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Client;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'adresse' => 'required|string',
            'tel' => 'required|string|unique:users,tel',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $client = Client::create([
            'nom' => $fields['nom'],
            'prenom' => $fields['prenom'],
            'adresse' => $fields['adresse'],
            'tel' => $fields['tel'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'role' => 'client'
        ]);

        $token = $client->createToken('myapptoken')->plainTextToken;
        $response = [
            'client' => $client,
            'token' => $token
        ];
        
        return response($response, 201);
    }

    
    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user){
            return response([
                'message' => 'bed client creds'
            ], 401);
        }

        if($user->role === 'client'){

            $client = Client::where('email', $fields['email'])->first();
    
            if(!Hash::check($fields['password'], $client->password)){
                return response([
                    'message' => 'bed client creds'
                ], 401);
            }
    
            $token = $client->createToken('myapptoken')->plainTextToken;
            $response = [
                'user' => $client,
                'token' => $token
            ];

        }elseif($user->role === 'admin'){

            $admin = Admin::where('email', $fields['email'])->first();
    
            if(!$admin || !Hash::check($fields['password'], $admin->password)){
                return response([
                    'message' => 'bed admin creds'
                ], 401);
            }
    
            $token = $admin->createToken('myapptoken')->plainTextToken;
            $response = [
                'user' => $admin,
                'token' => $token
            ];
        }
        
        return response($response, 200);
    }

    public function logout(Request $request){
        
        auth()->user()->tokens->each(function($token, $key) {
            $token->delete();
        });
        return [
            'messsage' => 'logged out'
        ];
    }
}
