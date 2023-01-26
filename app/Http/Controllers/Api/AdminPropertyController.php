<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyListResource;
use App\Http\Resources\PropertyViewResource;
use App\Http\Resources\UserResource;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPropertyController extends Controller
{
    // landlords
    public function landlords(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $users = User::whereRelation('roles', 'slug', '=', 'landlord')
            ->get();
        return UserResource::collection($users);
    }

    // clients
    public function clients(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $users = User::whereRelation('roles', 'slug', '=', 'client')
            ->orWhereDoesntHave('roles')
            ->get();
        return UserResource::collection($users);
    }

    // approve
    public function approve(Property $property): \Illuminate\Http\JsonResponse
    {
        $property->update([
            'status' => 'approved',
            'date_approved' => now(),
            'approved_by' => auth()->id(),
        ]);

        return response()->json([
            'status' => Response::HTTP_OK,
            'type' => 'success',
            'message' => 'approved',
            'property' => new PropertyViewResource($property),
        ], Response::HTTP_OK);
    }

    // transfer
    public function transfer(Request $request, Property $property): \Illuminate\Http\JsonResponse
    {
        $request->validate(['customer' => ['required']]);

        $property->update([
            'author_id' => $request->input('customer'),
        ]);

        return response()->json([
            'status' => Response::HTTP_OK,
            'type' => 'success',
            'message' => 'transferred',
            'property' => new PropertyViewResource($property),
        ], Response::HTTP_OK);
    }
}
