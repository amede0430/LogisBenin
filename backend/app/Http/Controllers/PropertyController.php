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
         // Récupérer le paramètre category_id de la requête
         $type = $request->query('type');
         $Properties = collect();
         // Si 'all' ou aucune catégorie n'est spécifiée, tous les posts sont retournés
         if ($type && $type !== 'all') {
             // Filtrer les posts selon la catégorie sélectionnée
             $Properties = Property::where('type', $type)->with(["owner","images"])->get();
         } else {
             // Afficher tous les posts si 'all' ou aucune catégorie n'est sélectionnée
             $Properties = Property::with(["owner","images"])->get();
         }
        return response()->json($Properties);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddPropertyRequest $request)
    {
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
        if(auth()->user()->id != $property->user_id){
            return response()->json([
                "message" => "You are not allowed to update the property"
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
        if(auth()->user()->id != $property->user_id){
            return response()->json([
                "message" => "You are not allowed to delete the property"
            ],403);
        }
        foreach($property->images as $image){
            Storage::disk("public")->delete($image->image_url);
        }
        $property->delete();
        return response()->json();
    }
}
