<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Jobs\VerifyPayment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    // index
    public function index()
    {
        $payments = Payment::get();
        return PaymentResource::collection($payments);
    }

    // store
    public function store(Request $request)
    {
        try {
            $data = $request->input('data');
            $payment = Payment::create([
                'customer_name' => $data['customer']['name'],
                'customer_email' => $data['customer']['email'],
                'customer_phone_number' => $data['customer']['phone_number'],
                'txn_id' => $data['transaction_id'],
                'txn_ref' => $data['tx_ref'],
                'flw_ref' => $data['flw_ref'],
                'currency' => $data['currency'],
                'amount_charged' => $data['amount'],
            ]);

            VerifyPayment::dispatch($payment);
            return response()->json([
                'status' => Response::HTTP_CREATED,
                'type' => 'success',
                'message' => 'created',
                'payment' => $payment,
                ], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            \Log::channel('slack')->info($e->getMessage());
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'type' => 'error',
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    // show
    public function show(Payment $payment)
    {
        //
    }

    // update
    public function update(Request $request,
                           Payment $payment)
    {
        //
    }

    // trash
    public function destroy(Payment $payment)
    {
        //
    }
}
