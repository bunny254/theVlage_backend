<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function revokeRoles(User $user)
    {
        $user->roles()->detach();
        return response()->json([
            'status' => Response::HTTP_OK,
            'type' => 'success',
            'message' => 'roles revoked',
            'user' => new UserResource($user)
        ], Response::HTTP_OK);
    }

    public function updateRoles(Request $request, User $user)
    {
        $request->validate([
            'role' => ['bail', 'required', Rule::in(['client', 'landlord', 'admin'])]
        ]);

        $user->roles()->detach();
        $user->giveRoles($request->input('role'));
        return response()->json([
            'status' => Response::HTTP_OK,
            'type' => 'success',
            'message' => 'roles updated',
            'user' => new UserResource($user)
        ], Response::HTTP_OK);

    }

}
