<?php

namespace App\Services;

class KYCService
{
    public static function sandboxVerify($async = false)
    {
        $api_key = config('services.smile_id.sb_api_key');
        $partner_id = config('services.smile_id.partner_id');
        $timestamp = now()->getTimestamp();
        $dateStr = date(\DateTimeInterface::ISO8601, $timestamp);
        $message = $dateStr . $partner_id . "sid_request";
        $signature = base64_encode(hash_hmac('sha256', $message, $api_key, true));
        $job_id = \Str::uuid();
        $user_id = \Str::uuid();

        if ($async) {
            $url = config('services.smile_id.sb_async_url');
        } else {
            $url = config('services.smile_id.sb_sync_url');
        }

        $response = \Http::post($url, [
            'partner_id' => $partner_id,
            'timestamp' => $dateStr,
            'signature' => $signature,
            'country' => 'KE',
            'id_type' => 'NATIONAL_ID',
            'id_number' => '00000000',
            'first_name' => 'John',
            'middle_name' => 'Doe',
            'last_name' => 'Leo',
            "phone_number" => "0123456789",
            "dob" => "2000-09-20",
            "gender" => "M",
            'partner_params' => [
                'job_id' => $job_id,
                'user_id' => $user_id
            ]
        ]);

        return response()->json($response->json());
    }

    public static function liveVerify($first_name, $last_name, $id_number, $id_type = 'NATIONAL_ID', $async = false): array
    {
        /*
         $api_key = "<Your Signature API Key>";
$partner_id = "<Your partner id>";
$timestamp = new DateTime()->getTimestamp();
$message = date(DateTimeInterface::ISO8601, $timestamp).$partner_id."sid_request";
$signature = base64_encode(hash_hmac('sha256', $message, $api_key, true));
         * */
        $api_key = config('services.smile_id.api_key');
        $partner_id = config('services.smile_id.partner_id');
        $timestamp = now()->getTimestamp();
        $dateStr = date(\DateTimeInterface::ISO8601, $timestamp);
        $message = $dateStr . $partner_id . "sid_request";
        $signature = base64_encode(hash_hmac('sha256', $message, $api_key, true));
        $job_id = \Str::uuid();
        $user_id = \Str::uuid();

        if ($async) {
            $url = config('services.smile_id.async_url');
        } else {
            $url = config('services.smile_id.sync_url');
        }

        $response = \Http::post($url, [
            'partner_id' => $partner_id,
            'timestamp' => $dateStr,
            'signature' => $signature,
            'country' => 'KE',
            'id_type' => $id_type,
            'id_number' => $id_number,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'partner_params' => [
                'job_id' => $job_id,
                'user_id' => $user_id
            ]
        ]);

        return ['data' => $response->json()];
    }
}
