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
        $firebaseToken = "ftrVkMQNpdhfeKTpt4eA8X:APA91bHMGx9_dlxd6OXAhrvQWTW5YTFMy3shN8cqEy2TStqmiymS2Wn4qzX0x8_jI-SURznIS1PGbDGk-1r0O-PGi58eZhJ9QSBz_L-Fqo7FYKFRN4l-Tl0";

        // Load Firebase credentials
        $factory = (new Factory)->withServiceAccount(storage_path('app/firebase/apadabali-7d57a-firebase-adminsdk-fbsvc-9efa655d53.json'));

        $messaging = $factory->createMessaging();

        // Buat pesan notifikasi
        $message = CloudMessage::withTarget('token', $firebaseToken)
            ->withNotification(Notification::create('New Message', 'You have a new notification!'))
            ->withData(['click_action' => 'FLUTTER_NOTIFICATION_CLICK']); // Opsional untuk data tambahan

        // Kirim notifikasi
        $messaging->send($message);

        return response()->json(['message' => 'Notification sent successfully!']);
    }
}
