<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MyBookingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->hasRole('admin')) {
            $bookings = Booking::query();
        } else {
            $bookings = Booking::mine()
                ->where('admin_confirmed', '=', true);
        }
        return BookingResource::collection($bookings->paginate());
    }

    /**
     * @throws \Throwable
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function confirm(Booking $booking)
    {
        $this->authorize('update', $booking);
        DB::beginTransaction();
        try {
            $user = auth()->user();
            if ($user->hasRole('landlord')) {
                if (!$booking->admin_confirmed) {
                    return response()->json([
                        'status' => Response::HTTP_PRECONDITION_FAILED,
                        'type' => 'error',
                        'message' => 'not approved by admin'
                    ], Response::HTTP_PRECONDITION_FAILED);
                }
                $booking->update(['landlord_confirmed' => true, 'status' => 2]);
                $booking->property()->update(['available_from' => $booking->check_out_date]);
                $message = 'confirmed';
            } else {
                $booking->update(['admin_confirmed' => true, 'status' => 1]);
                $message = 'pending landlord approval';
            }

            DB::commit();
            return response()->json([
                'status' => Response::HTTP_OK,
                'type' => 'success',
                'message' => $message
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'type' => 'error',
                'message' => $e->getMessage() ?? 'Error in booking confirmation'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
