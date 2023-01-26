<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function __invoke(RegisterRequest $request)
    {
        $request->validated();

        \DB::beginTransaction();
        try {
            $verification = \App\Services\KYCService::liveVerify(
                $request->input('first_name'),
                $request->input('surname'),
                $request->input('id_number'),
                $request->input('id_type')
            );
            $resCode = intval($verification['data']['ResultCode']);
            $acceptableCodes = [1020, 1021];
            if (!in_array($resCode, $acceptableCodes)) {
                return response()->json([
                    'message' => 'KYC verification failed',
                    'status' => Response::HTTP_PRECONDITION_FAILED
                ], Response::HTTP_PRECONDITION_FAILED);
            }

            $otp_code = random_int(100000, 999999);

            $user = User::create([
                'surname' => $request->input('surname'),
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'id_number' => $request->input('id_number'),
                'id_type' => $request->input('id_type'),
                'gender' => $request->input('gender'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'password' => \Hash::make($request->input('password')),
                'otp_code' => $otp_code
            ]);

            if (in_array($request->input('role'), ['client', 'landlord'])) {
                $role = Role::where('slug', '=', $request->input('role'))->first();
                $user->roles()->attach($role);
            }


            \DB::commit();

            $user->sendVerificationNotification($otp_code);

            return response()->json([
                'status' => Response::HTTP_CREATED, 'type' => 'success', 'message' => 'created'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            \DB::rollBack();
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST, 'type' => 'error', 'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
