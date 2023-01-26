<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile() {
        $user = auth()->user();
        return response()->json([
                'status' => Response::HTTP_OK,
            'type' => 'success',
            'message' => 'success',
            'user' => new UserResource($user),
            ], Response::HTTP_OK);
    }

    public function verify(Request $request) {
        $request->validate([
            'otp_code' => ['bail', 'required', 'string']
        ]);

        $user = auth()->user();

        if ($user->isVerified()) {
            $user->update(['otp_code' => NULL]);
            return response()->json([
                'status' => Response::HTTP_OK, 'type' => 'success', 'message' => 'account already verified',
            ], Response::HTTP_OK);
        }

        if ($user->otp_code !== $request->otp_code) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST, 'type' => 'error', 'error' => 'invalid otp code',
            ], Response::HTTP_BAD_REQUEST);
        }

        if (!$user->isVerified()) {
            $user->markAsVerified();
            $user->update(['otp_code' => NULL]);
        }

        return response()->json([
                'status' => Response::HTTP_OK, 'type' => 'success', 'message' => 'account verified',
            ], Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->user()->tokens()->delete();
        return response()->json([
                'status' => Response::HTTP_OK, 'type' => 'success', 'message' => 'logout success',
            ], Response::HTTP_OK);
    }
}
