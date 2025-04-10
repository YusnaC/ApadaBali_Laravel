<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\DeviceToken;

class FCMController extends Controller
{
    public function saveToken(Request $request)
    {
        try {
            $user = auth()->user();
            
            if (!$user) {
                Log::error('FCM Token Save: User not authenticated');
                return response()->json(['message' => 'User not authenticated'], 401);
            }

            // Validate required fields
            $request->validate([
                'device_token' => 'required',
                'device_id' => 'required',
                'device_type' => 'required|in:android,ios,web'
            ]);

            Log::info('Attempting to save token for user: ' . $user->id);
            Log::info('Received token: ' . $request->device_token);

            // Update or create device token
            DeviceToken::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'device_id' => $request->device_id,
                ],
                [
                    'fcm_token' => $request->device_token,
                    'device_type' => $request->device_type
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'FCM Token saved successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('FCM Token Save Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error saving token',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}