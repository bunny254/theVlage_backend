<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'web_hook_url' => env('SLACK_WEBHOOK_URL')
    ],

    'flutterwave' => [
        'public_key' => env('FLUTTERWAVE_PUBLIC_KEY'),
        'secret_key' => env('FLUTTERWAVE_SECRET_KEY'),
        'encryption_key' => env('FLUTTERWAVE_ENCRYPTION_KEY'),
    ],
    'smile_id' => [
        'sb_api_key' => env('SMILE_SB_API_KEY'),
        'sb_async_url' => env('SMILE_SB_ASYNC_URL'),
        'sb_sync_url' => env('SMILE_SB_SYNC_URL'),
        'api_key' => env('SMILE_API_KEY'),
        'partner_id' => env('SMILE_PARTNER_ID'),
        'async_url' => env('SMILE_ASYNC_URL'),
        'sync_url' => env('SMILE_SYNC_URL'),
    ],

];
