importScripts('https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js');

// 🔥 YOUR FIREBASE CONFIG
firebase.initializeApp({
  apiKey: "AIzaSyAQLjzYYiC35OlGEzrDMr-oKgKxCQN7lK0",
  authDomain: "dreminder-d1412.firebaseapp.com",
  projectId: "dreminder-d1412",
  storageBucket: "dreminder-d1412.firebasestorage.app",
  messagingSenderId: "697606460456",
  appId: "1:697606460456:web:cf3f2f1c5dac92c8b6d11d"
});

const messaging = firebase.messaging();

// 🔔 Handle background notifications
messaging.onBackgroundMessage(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);

  const notificationTitle = payload.notification.title || "Notification";
  const notificationOptions = {
    body: payload.notification.body,
    icon: '/icon.png' // optional
  };

  self.registration.showNotification(notificationTitle, notificationOptions);
});