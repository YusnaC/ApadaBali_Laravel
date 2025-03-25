<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\DB;
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
    try {
        \Log::info('Received token request:', ['token' => $request->device_token]);
        
        $updated = DB::table('users')
            ->where('id', 1)  // Testing with user ID 1
            ->update([
                'fcm_token' => $request->device_token
            ]);

        \Log::info('Update result:', ['updated' => $updated]);

        return response()->json([
            'message' => 'Token saved successfully',
            'token' => $request->device_token
        ]);

    } catch (\Exception $e) {
        \Log::error('Detailed error: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        return response()->json([
            'error' => 'Server error',
            'message' => $e->getMessage()
        ], 500);
    }
});
