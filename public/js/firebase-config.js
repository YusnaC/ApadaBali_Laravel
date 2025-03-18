import { initializeApp } from "firebase/app";
import { getMessaging, getToken, onMessage } from "firebase/messaging";

// Ganti dengan konfigurasi Firebase Anda
const firebaseConfig = {
    apiKey: "AIzaSyDwdTMsU9BI2X4D2I7K2-TrSZKS44fHcqQ",
    authDomain: "apadabali-7d57a.firebaseapp.com",
    projectId: "apadabali-7d57a",
    storageBucket: "apadabali-7d57a.firebasestorage.app",
    messagingSenderId: "493616207475",
    appId: "1:493616207475:web:9484bb31b498282db73c06",
    measurementId: "G-DFX5JWYE7C",
    vapidKey: "BDbzKpYdkjEeUhGuXFl2QIP0CKIqUi0cb0MKBIb8BwJ5Tdc9YXgs4MqUQVGWYLAuW80IUqZI5byUjJJj0bDnz0Y", // Pastikan VAPID Key sudah benar
};

// Inisialisasi Firebase
const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// Minta izin notifikasi saat halaman dimuat
export function requestNotificationPermission() {
  Notification.requestPermission().then((permission) => {
    if (permission === "granted") {
      getToken(messaging, { vapidKey: firebaseConfig.vapidKey })
        .then((token) => {
          if (token) {
            console.log("Token FCM:", token);
            // Kirim token ke backend jika perlu
          } else {
            console.log("Tidak ada token yang tersedia");
          }
        })
        .catch((err) => console.error("Gagal mendapatkan token", err));
    }
  });
}

export { messaging };
