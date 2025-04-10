<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class NotificationController extends Controller
{
    public function saveFcmToken(Request $request)
    {
        try {
            $token = $request->input('device_token');
            
            if (!$token) {
                return response()->json(['success' => false, 'message' => 'Token is required'], 400);
            }

            // Update or create token for the authenticated user
            auth()->user()->update(['fcm_token' => $token]);

            return response()->json(['success' => true, 'message' => 'Token saved successfully']);
        } catch (\Exception $e) {
            \Log::error('FCM Token Save Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to save token'], 500);
        }
    }

    public function sendNotification(Request $request)
    {
        try {
            $drafterId = $request->input('drafter_id');

            // Get tokens based on drafter_id
            $query = \DB::table('users')->whereNotNull('fcm_token');
            
            if ($drafterId) {
                $query->where('id_drafter', $drafterId);
            }
            
            $firebaseTokens = $query->pluck('fcm_token')->toArray();

            if (empty($firebaseTokens)) {
                \Log::warning('No FCM tokens found for drafter ID: ' . $drafterId);
                return response()->json([
                    'success' => false,
                    'message' => 'No registered devices found for the specified drafter'
                ], 404);
            }

            $factory = (new Factory)->withServiceAccount(storage_path('app/firebase/apadabali-7d57a-firebase-adminsdk-fbsvc-9efa655d53.json'));
            $messaging = $factory->createMessaging();

            $notification = Notification::create()
                ->withTitle($request->input('title', 'Notifikasi Baru'))
                ->withBody($request->input('message', 'Ada pembaruan proyek!'))
                ->withPriority('high');

            foreach ($firebaseTokens as $token) {
                try {
                    $message = CloudMessage::withTarget('token', $token)
                        ->withNotification($notification)
                        ->withData([
                            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                            'drafter_id' => $drafterId,
                            'project_id' => $request->input('project_id'),
                            'type' => 'project_notification',
                            'timestamp' => now()->timestamp,
                            'sound' => 'default'
                        ])
                        ->withAndroidConfig([
                            'priority' => 'high',
                            'notification' => [
                                'channel_id' => 'project_notifications'
                            ]
                        ])
                        ->withApnsConfig([
                            'headers' => [
                                'apns-priority' => '10',
                            ],
                            'payload' => [
                                'aps' => [
                                    'sound' => 'default',
                                    'badge' => 1
                                ]
                            ]
                        ]);

                    $result = $messaging->send($message);
                    \Log::info('Notification sent successfully', [
                        'token' => $token, 
                        'drafter_id' => $drafterId,
                        'result' => $result
                    ]);
                } catch (\Exception $tokenError) {
                    \Log::warning('Failed to send to token: ' . $token . ' Error: ' . $tokenError->getMessage());
                    continue;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Notifications sent successfully!'
            ]);

        } catch (\Exception $e) {
            \Log::error('Notification Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send notifications: ' . $e->getMessage()
            ], 500);
        }
    }
}
