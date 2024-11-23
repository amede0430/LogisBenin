<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AddPropertyRequest;
use App\Http\Requests\EditPropertyRequest;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Property::with(['owner', 'images']);

        // Filtrage par type de propriété 
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }

        // Filtrage par localisation 
        if ($request->has('location') && !empty($request->location)) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Filtrage par prix minimum 
        if ($request->has('min_price') && !empty($request->min_price)) {
            $query->where('price', '>=', $request->min_price);
        }

        // Filtrage par prix maximum 
        if ($request->has('max_price') && !empty($request->max_price)) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filtrage par surface minimale 
        if ($request->has('min_surface_area') && !empty($request->min_surface_area)) {
            $query->where('surface_area', '>=', $request->min_surface_area);
        }

        // Filtrage par surface maximale 
        if ($request->has('max_surface_area') && !empty($request->max_surface_area)) {
            $query->where('surface_area', '<=', $request->max_surface_area);
        }

        // Filtrage par nombre de chambres
        if ($request->has('rooms') && !empty($request->rooms)) {
            $query->where('rooms', '=', $request->rooms);
        }

        // Filtrage par status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', '=', $request->status);
        }

        // Exécuter la requête et retourner les résultats
        $properties = $query->get();

        return response()->json($properties);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(AddPropertyRequest $request)
    {
        // Vérifier si l'utilisateur est un agent ou un propriétaire et s'il est validé
        $user = auth()->user();
        if (($user->role != 'owner' && $user->role != 'agent') || !$user->is_validated) {
            return response()->json([
                'message' => "Vous n'êtes pas autorisé à créer une propriété, votre compte n'est pas validé ou vous n'avez pas le rôle requis."
            ], 403);
        }

        $property = Property::create([
            "title" => $request->title,
            "description" => $request->description,
            "type" => $request->type,
            "price" => $request->price,
            "location" => $request->location,
            "surface_area" => $request->surface_area,
            "rooms" => $request->rooms,
            "status" => $request->status,
            "user_id" => auth()->user()->id
        ]);

        foreach($request->file("images") as $image){
            $images_url_data = [
                "property_id" => $property->id,
                "image_url" => $image->store("properties","public")
            ];
            PropertyImage::create($images_url_data);
        }
        return response()->json([
            
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        return response()->json([
            $property
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditPropertyRequest $request, Property $property)
    {
        // Vérifier si l'utilisateur est autorisé à modifier la propriété
        if (auth()->user()->id != $property->user_id || !auth()->user()->is_validated) {
            return response()->json([
                "message" => "Vous n'êtes pas autorisé à mettre à jour la propriété."
            ], 403);
        }

        if(auth()->user()->id != $property->user_id){
            return response()->json([
                "message" => "Vous n'êtes pas autorisé à mettre à jour la propriété."
            ],403);
        }

        $property->update($request->validated());

        return response()->json([
            $property
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        // Vérifier si l'utilisateur est autorisé à modifier la propriété
        if (auth()->user()->id != $property->user_id || !auth()->user()->is_validated) {
            return response()->json([
                "message" => "Vous n'êtes pas autorisé à supprimer la propriété."
            ], 403);
        }

        if(auth()->user()->id != $property->user_id){
            return response()->json([
                "message" => "Vous n'êtes pas autorisé à supprimer la propriété."
            ],403);
        }

        foreach($property->images as $image){
            Storage::disk("public")->delete($image->image_url);
        }

        $property->delete();
        
        return response()->json();
    }
}
