importScripts('https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js');

// 🔥 YOUR FIREBASE CONFIG
firebase.initializeApp({
  apiKey: "AIzaSyDlGivL9-JkcLIgrNs8eEzpjE5z_kDKrKY",
  authDomain:  "winngoodreminder.firebaseapp.com",
  projectId: "winngoodreminder",
  storageBucket:  "winngoodreminder.firebasestorage.app",
  messagingSenderId: "277371297505",
  appId: "1:277371297505:web:ffd23bb9bbda99e0d161a0",
});

const messaging = firebase.messaging();

// 🔔 BACKGROUND MESSAGE
messaging.onBackgroundMessage(function(payload) {

  console.log('Background message:', payload);

  const title = payload.data.title;
  const options = {
    body: payload.data.body,
    icon: '/icon.png'
  };

  self.registration.showNotification(title, options);
});

