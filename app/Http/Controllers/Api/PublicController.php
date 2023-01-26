<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyListResource;
use App\Http\Resources\PropertyViewResource;
use App\Models\Property;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function properties(Request $request)
    {
        $properties = Property::approved();
        if ($request->has('location')) {
            $properties->like('location', $request->query('location'));
        }

        if ($request->has('name')) {
            $properties->like('name', $request->query('name'));
        }

        if ($request->has('type')) {
            $properties->like('listing_type', $request->query('type'));
        }

        if ($request->has('from')) {
            $properties->availability($request->query('from'));
        }

        if ($request->has('guests')) {
            $properties->rooms('bedrooms', $request->query('guests'));
        }

        return PropertyListResource::collection($properties->paginate());
    }

    public function propertyView(Property $property)
    {
        return new PropertyViewResource($property);
    }
}
