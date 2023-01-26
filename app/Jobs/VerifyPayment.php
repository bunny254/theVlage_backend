<?php

namespace App\Jobs;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VerifyPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Payment $payment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $txn_id = $this->payment->txn_id;
        $url = "https://api.flutterwave.com/v3/transactions/$txn_id/verify";
        $response = \Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . config('services.flutterwave.secret_key')
        ])->get($url);

        if ($response['status'] == 'success') {
            $this->payment->update([
                'is_verified' => true,
                'status' => $response['data']['processor_response'],
                'amount_charged' => $response['data']['charged_amount'],
                'app_fee' => $response['data']['app_fee'],
                'merchant_fee' => $response['data']['merchant_fee'],
                'amount_settled' => $response['data']['amount_settled']
            ]);
        } else {
            $this->payment->update([
                'is_verified' => false,
                'status' => $response['message'],
            ]);
        }
        \Log::info($response);

    }
}
