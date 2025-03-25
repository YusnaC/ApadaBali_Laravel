import { initializeApp } from "firebase/app";
import { getMessaging, onMessage, getToken } from "firebase/messaging";

// Firebase Config
const firebaseConfig = {
    apiKey: "AIzaSyDwdTMsU9BI2X4D2I7K2-TrSZKS44fHcqQ",
    authDomain: "apadabali-7d57a.firebaseapp.com",
    projectId: "apadabali-7d57a",
    storageBucket: "apadabali-7d57a.firebasestorage.app",
    messagingSenderId: "493616207475",
    appId: "1:493616207475:web:9484bb31b498282db73c06",
    measurementId: "G-DFX5JWYE7C"
    
}
// Initialize Firebase
const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// Dapatkan Token FCM
export const requestPermission = async () => {
    try {
        const token = await getToken(messaging, { vapidKey: "BDbzKpYdkjEeUhGuXFl2QIP0CKIqUi0cb0MKBIb8BwJ5Tdc9YXgs4MqUQVGWYLAuW80IUqZI5byUjJJj0bDnz0Y" });
        console.log("FCM Token:", token);
        return token;
    } catch (error) {
        console.error("Error getting token:", error);
    }
};

// Menerima notifikasi saat aplikasi berjalan
onMessage(messaging, (payload) => {
    console.log("Notification received:", payload);
    alert(payload.notification.title + ": " + payload.notification.body);
});
