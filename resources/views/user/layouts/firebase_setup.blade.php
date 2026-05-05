<script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js"></script>

<script>
const firebaseConfig = {
  apiKey: "AIzaSyAQLjzYYiC35OlGEzrDMr-oKgKxCQN7lK0",
  authDomain: "dreminder-d1412.firebaseapp.com",
  projectId: "dreminder-d1412",
  storageBucket: "dreminder-d1412.firebasestorage.app",
  messagingSenderId: "697606460456",
  appId: "1:697606460456:web:cf3f2f1c5dac92c8b6d11d"
};

if (!firebase.apps.length) {
  firebase.initializeApp(firebaseConfig);
}

const messaging = firebase.messaging();

// 🔔 ADD HERE (IMPORTANT)
messaging.onMessage((payload) => {
  console.log("Foreground:", payload);

  new Notification(payload.data.title, {
    body: payload.data.body,
    icon: "/icon.png"
  });
});
</script>