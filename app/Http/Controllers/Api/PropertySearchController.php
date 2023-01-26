<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyListResource;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertySearchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function __invoke(Request $request)
    {
        $properties = Property::query();
        if ($request->has('q')) {
            $q = $request->q;
            $properties->where('location', 'like', "%{$q}%")
                ->orWhere('name', 'like', "%{$q}%");
        }
        $properties->paginate();
        return PropertyListResource::collection($properties);
    }
}
