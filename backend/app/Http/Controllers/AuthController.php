<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AddAgentUserRequest;
use App\Http\Requests\AddClientUserRequest;
use App\Http\Requests\AddOwnerUserRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            /**
             * @var User
             */
            $user = Auth::user();
            return response()->json([
                "user" => $user,
                "token" => $user->createToken("logisBenin")->plainTextToken
            ]);
        } else {
            return response()->json([
                "message" => "Invalid credentials"
            ], 401);
        }
    }

    public function register_client(AddClientUserRequest $request)
    {
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "phone_number" => $request->phone_number,
            "role" => User::ROLES['client'],
        ]);

        return response()->json([], 201);
    }

    public function register_agent(AddAgentUserRequest $request)
    {
        $agent = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "phone_number" => $request->phone_number,
            "role" => User::ROLES['agent'],
            "agency_name" => $request->agency_name,
            "tax_identification_number" => $request->tax_identification_number,
            "rccm" => $request->rccm,
            "exercise_authorization" => $request->exercise_authorization,
            "intervention_zone" => $request->intervention_zone,
            "agency_phone" => $request->agency_phone,
            "agency_email" => $request->agency_email,
        ]);

        // Gestion des fichiers multiples
        if ($request->hasFile('rccm_copy')) {
            foreach ($request->file('rccm_copy') as $file) {
                $agent->rccm_copy[] = $file->store('agents/rccm_copies', 'public');
            }
        }
        if ($request->hasFile('exercise_authorization_copy')) {
            foreach ($request->file('exercise_authorization_copy') as $file) {
                $agent->exercise_authorization_copy[] = $file->store('agents/authorization_copies', 'public');
            }
        }
        if ($request->hasFile('address_proof')) {
            foreach ($request->file('address_proof') as $file) {
                $agent->address_proof[] = $file->store('agents/address_proofs', 'public');
            }
        }

        $agent->save();

        return response()->json([], 201);
    }


    public function register_owner(AddOwnerUserRequest $request)
    {
        $owner = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "phone_number" => $request->phone_number,
            "role" => User::ROLES['owner'],
        ]);

        // Gestion des fichiers multiples pour le propriétaire
        if ($request->hasFile('property_title')) {
            foreach ($request->file('property_title') as $file) {
                $owner->property_title[] = $file->store('owners/property_titles', 'public');
            }
        }
        if ($request->hasFile('identity_document')) {
            foreach ($request->file('identity_document') as $file) {
                $owner->identity_document[] = $file->store('owners/identity_documents', 'public');
            }
        }

        $owner->save();

        return response()->json([], 201);
    }


}
