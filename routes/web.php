<?php

use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome')->with([
        'BASE_URL' => 'https://backend.thevlage.com/api',
        'TOKEN' => 'Bearer Token'
    ]);
});

Route::get('debugger', function () {
    // $payments = \App\Models\Payment::get();
    $res =  \App\Services\KYCService::liveVerify(
        'Martin',
        'Kinyua',
        'A1627510',
        'PASSPORT'
    );

    return [
        'data' => $res['data'],
        'code' => $res['data']['ResultCode']
    ];
    /*$txn_id = 2660701;
    $url = "https://api.flutterwave.com/v3/transactions/$txn_id/verify";
    $response = \Http::withHeaders([
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . config('services.flutterwave.public_key')
    ])->get($url);
    return response([
        'status' => $response['status'],
        'message' => $response['message'],
        'data' => $response['data']
    ]);*/
//    Log::channel('slack')->info('Testing Slack Logging');
    // ->route('slack', config('services.slack.web_hook_url'))
    /*Notification::route('mail', 'thekiharani@gmail.com')
        ->notify(new \App\Notifications\SlackNotification());*/
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    // Alert::success('Success Title', 'Success Message')->timerProgressBar();
    // toast('Signed in successfully','success')->timerProgressBar();
    return view('dashboard');
})->name('dashboard');
