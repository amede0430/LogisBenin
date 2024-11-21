<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AddAgentUserRequest;
use App\Http\Requests\AddClientUserRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        if(Auth::attempt($request->validated())){
            /**
             * @var User
             */
            $user = Auth::user();
            return response()->json([
                "user" => $user,
                "token" => $user->createToken("logisBenin")->plainTextToken
            ]);
        }else{
            return response()->json([
                "message" => "Invalids credentials"
            ],401);
        }
    }
    public function register_client(AddClientUserRequest $request){
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "phone_number" => $request->phone_number,
            "role" => "client"
        ]);
        return response()->json([],201);
    }
    public function register_agent(AddAgentUserRequest $request){
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password,
            "phone_number" => $request->phone_number,
            "role" => "agent"
        ]);
        return response()->json([],201);
    }
}
