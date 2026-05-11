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

// importScripts('https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js');
// importScripts('https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js');

// firebase.initializeApp({
//   apiKey: "AIzaSyAQLjzYYiC35OlGEzrDMr-oKgKxCQN7lK0",
//   authDomain: "dreminder-d1412.firebaseapp.com",
//   projectId: "dreminder-d1412",
//   storageBucket: "dreminder-d1412.firebasestorage.app",
//   messagingSenderId: "697606460456",
//   appId: "1:697606460456:web:cf3f2f1c5dac92c8b6d11d"
// });

// const messaging = firebase.messaging();

// messaging.onBackgroundMessage(function(payload) {

//   console.log('Background message:', payload);

//   const title =
//     payload.data.title || 'Reminder Alert';

//   const options = {

//     body:
//       payload.data.body || 'Reminder received',

//     icon: '/icon.png',

//     badge: '/icon.png',

//     requireInteraction: true,

//     vibrate: [500, 300, 500, 300, 500],

//     tag: 'dreminder-alert',

//     renotify: true,

//     data: {
//       sound: '/assets/audio/reminder_sound.mp3'
//     }
//   };

//   self.registration.showNotification(
//     title,
//     options
//   );

//   // 🔥 AUTO CLOSE AFTER 1 MINUTE
//   setTimeout(async () => {

//     const notifications =
//       await self.registration.getNotifications();

//     notifications.forEach(n => {

//       if (n.tag === 'dreminder-alert') {

//         n.close();
//       }
//     });

//   }, 60000);
// });

// // 🔥 PLAY SOUND WHEN NOTIFICATION SHOWS
// self.addEventListener('notificationclick', function(event) {

//   event.notification.close();

//   event.waitUntil(

//     clients.openWindow('/')
//   );
// });