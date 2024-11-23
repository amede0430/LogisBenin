<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AdminController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route pour récupérer les informations de l'utilisateur connecté
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentification et enregistrement des utilisateurs
Route::post("login", [AuthController::class, "login"]);
Route::post("register/client", [AuthController::class, "register_client"]);
Route::post("register/agent", [AuthController::class, "register_agent"]);
Route::post("register/owner", [AuthController::class, "register_owner"]);

// Routes protégées
Route::middleware("auth:sanctum")->group(function () {
    // Gestion des propriétés
    Route::apiResource("properties", PropertyController::class);

    // Route pour valider les comptes (admin uniquement)
    Route::middleware("admin")->patch("validate-account/{id}", [AdminController::class, "validate_account"]);
});
