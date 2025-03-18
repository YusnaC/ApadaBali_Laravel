<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/send-notification', [NotificationController::class, 'sendNotification']);

Route::post('/save-fcm-token', function (Request $request) {
    $user = auth()->user();
    $user->fcm_token = $request->device_token;
    $user->save();

    return response()->json(['message' => 'FCM Token saved successfully']);
});
