<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(LoginRequest $request) {
        $user = User::where('email', $request->email)
                // ->orWhere('phone_number', $request->email)
                ->first();

        if ($user && \Hash::check($request->password, $user->password)) {
            $user->tokens()->delete();
            $token = $user->createToken("personal-access")->plainTextToken;
            $tokenOnly = explode('|', $token)[1];
            return response()->json([
                'status' => Response::HTTP_OK,
                'type' => 'success',
                'message' => 'login success',
                'token' => $tokenOnly,
                'user' => new UserResource($user)
            ], Response::HTTP_OK);
        }

        return response()->json([
                'status' => Response::HTTP_UNAUTHORIZED, 'type' => 'error', 'error' => 'invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
    }
}
