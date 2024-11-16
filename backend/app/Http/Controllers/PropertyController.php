<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Models\PropertyImage;
use App\Http\Requests\AddPropertyRequest;
use App\Http\Requests\EditPropertyRequest;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json( Property::with(["owner","images"])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddPropertyRequest $request)
    {
        $property = Property::create([
            "title" => $request->title,
            "description" => $request->title,
            "type" => $request->title,
            "price" => $request->title,
            "location" => $request->title,
            "surface_area" => $request->title,
            "rooms" => $request->title,
            "status" => $request->title,
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
        $property->delete();
        return response()->json();
    }
}
