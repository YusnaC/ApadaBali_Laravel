<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class NotificationController extends Controller
{
    public function sendNotification(Request $request)
    {
        try {
            $firebaseToken = "ftrVkMQNpdhfeKTpt4eA8X:APA91bHandcSblu8cdXa-rMzFpjDW14U3qiZ7FA1WjZgd6uEuMfeZcKYcTYlfgnoAHoQrqW2DvFx8-dneesHFJ3p-34qADUx9tlx2d-7fliH6PzoIrLhuEc";

            // Load Firebase credentials
            $factory = (new Factory)->withServiceAccount(storage_path('app/firebase/apadabali-7d57a-firebase-adminsdk-fbsvc-9efa655d53.json'));

            $messaging = $factory->createMessaging();

            // Get custom message data from request
            $title = $request->input('title', 'Notifikasi Baru');
            $message = $request->input('message', 'Ada pembaruan proyek!');
            $drafterId = $request->input('drafter_id', '1');

            // Create notification message
            $message = CloudMessage::withTarget('token', $firebaseToken)
                ->withNotification(Notification::create($title, $message))
                ->withData([
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                    'drafter_id' => $drafterId,
                    'type' => 'project_notification'
                ]);

            // Send notification
            $messaging->send($message);

            return response()->json([
                'success' => true,
                'message' => 'Notification sent successfully!'
            ]);

        } catch (\Exception $e) {
            \Log::error('Notification Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send notification'
            ], 500);
        }
    }
}
