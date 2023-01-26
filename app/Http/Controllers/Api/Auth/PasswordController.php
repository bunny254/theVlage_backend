<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Fortify\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class PasswordController extends Controller
{
    public function resetPassword(Request $request) {
        $request->validate([
            'email' => ['bail', 'required', 'email'],
        ]);

        $user = User::where('email', $request->email)
                ->first();

        if (!$user) {
            return response()->json([
                    'status' => Response::HTTP_NOT_FOUND, 'type' => 'error', 'error' => 'email not found'
                ], Response::HTTP_NOT_FOUND);
        }

        \DB::transaction(function () use ($user) {

            $password = \Str::random(8);

            $user->update([
                'password' => \Hash::make($password),
                'has_temporary_password' => true
            ]);

            $user->sendPasswordResetNotification($password);
        });

        return response()->json([
                'status' => Response::HTTP_OK, 'type' => 'success', 'message' => 'password reset',
            ], Response::HTTP_OK);
    }

    public function changePassword(Request $request) {
        $request->validate([
            'current_password' => ['bail', 'required', 'string'],
            'new_password' => ['bail', 'required', 'string', new Password],
        ]);

        $user = auth()->user();

        if (\Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => \Hash::make($request->new_password),
                'has_temporary_password' => false
            ]);

            return response()->json([
                    'status' => Response::HTTP_OK, 'type' => 'success', 'message' => 'password changed',
                ], Response::HTTP_OK);
        }
        return response()->json([
                'status' => Response::HTTP_BAD_REQUEST, 'type' => 'error', 'error' => 'current password is incorrect'
            ], Response::HTTP_BAD_REQUEST);
    }
}
