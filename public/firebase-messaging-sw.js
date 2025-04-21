// public/firebase-messaging-sw.js
self.importScripts(
    "https://www.gstatic.com/firebasejs/10.13.2/firebase-app-compat.js"
);
self.importScripts(
    "https://www.gstatic.com/firebasejs/10.13.2/firebase-messaging-compat.js"
);

firebase.initializeApp({
    apiKey: "AIzaSyDwdTMsU9BI2X4D2I7K2-TrSZKS44fHcqQ",
    authDomain: "apadabali-7d57a.firebaseapp.com",
    projectId: "apadabali-7d57a",
    storageBucket: "apadabali-7d57a.firebasestorage.app",
    messagingSenderId: "493616207475",
    appId: "1:493616207475:web:9484bb31b498282db73c06",
    measurementId: "G-DFX5JWYE7C",
});
const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    console.log("Received background message ", payload);
    self.registration.showNotification(payload.notification.title, {
        body: payload.notification.body,
        icon: "/icon.png",
    });
});
