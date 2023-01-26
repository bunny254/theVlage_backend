<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Property;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends Controller
{
    // constructor
    public function __construct()
    {
        $this->authorizeResource(Booking::class, 'booking');
    }

    // index
    public function index()
    {
        $bookings = Booking::owned()->withTrashed()->with(['property', 'author'])->paginate();
        return BookingResource::collection($bookings);
    }

    // store
    public function store(Property $property, BookingRequest $request)
    {
        if ($property->bedrooms*2 < $request->input('number_of_guests')) {
            return response()->json([
                'status' => Response::HTTP_PRECONDITION_FAILED,
                'type' => 'error',
                'error' => 'maximum of ' . $property->bedrooms*2 . ' guests are allowed'
            ], Response::HTTP_PRECONDITION_FAILED);
        }

        $booking = $property->bookings()->create([
            'number_of_guests' => $request->input('number_of_guests'),
            'price' => $request->input('price'),
            'rent_cost' => $request->input('rent_cost'),
            'deposit_cost' => $request->input('deposit_cost'),
            'amenities_cost' => $request->input('amenities_cost'),
            'other_costs' => $request->json('other_costs'),
            'check_in_date' => Carbon::createFromFormat('d/m/Y', $request->input('check_in_date')),
            'check_out_date' => Carbon::createFromFormat('d/m/Y', $request->input('check_out_date'))
        ]);

        return response()->json([
            'status' => Response::HTTP_CREATED,
            'type' => 'success',
            'message' => 'created',
            'booking' => $booking
        ], Response::HTTP_CREATED);
    }

    // show
    public function show(Booking $booking)
    {
        return new BookingResource($booking->load(['property', 'author']));
    }

    // update
    public function update(BookingRequest $request, Booking $booking)
    {
        if ($booking->property->bedrooms*2 < $request->input('number_of_guests')) {
            return response()->json([
                'status' => Response::HTTP_PRECONDITION_FAILED,
                'type' => 'error',
                'error' => 'maximum of ' . $booking->property->bedrooms*2 . ' guests are allowed'
            ], Response::HTTP_PRECONDITION_FAILED);
        }

        $booking->update([
            'number_of_guests' => $request->input('number_of_guests'),
            'price' => $request->input('price'),
            'rent_cost' => $request->input('rent_cost'),
            'deposit_cost' => $request->input('deposit_cost'),
            'amenities_cost' => $request->input('amenities_cost'),
            'other_costs' => $request->input('other_costs'),
            'check_in_date' => Carbon::createFromFormat('d/m/Y', $request->input('check_in_date')),
            'check_out_date' => Carbon::createFromFormat('d/m/Y', $request->input('check_out_date'))
        ]);

        return response()->json([
                'status' => Response::HTTP_OK, 'type' => 'success', 'message' => 'updated'
            ], Response::HTTP_OK);
    }

    // trash
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return response()->json([
                'status' => Response::HTTP_OK, 'type' => 'success', 'message' => 'trashed'
            ], Response::HTTP_OK);
    }

    // restore
    public function restore($booking)
    {
        Booking::onlyTrashed()->find($booking)->restore();
        return response()->json([
                'status' => Response::HTTP_OK, 'type' => 'success', 'message' => 'restored'
            ], Response::HTTP_OK);
    }
}
