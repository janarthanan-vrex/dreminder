


<script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js"></script>

<script>
const firebaseConfig = {
  apiKey: "AIzaSyDlGivL9-JkcLIgrNs8eEzpjE5z_kDKrKY",
  authDomain:  "winngoodreminder.firebaseapp.com",
  projectId: "winngoodreminder",
  storageBucket:  "winngoodreminder.firebasestorage.app",
  messagingSenderId: "277371297505",
  appId: "1:277371297505:web:ffd23bb9bbda99e0d161a0",
};

if (!firebase.apps.length) {
  firebase.initializeApp(firebaseConfig);
}

const messaging = firebase.messaging();

// ðŸ”¥ FOREGROUND NOTIFICATION
messaging.onMessage((payload) => {

  console.log("Foreground:", payload);

  // ðŸ”¥ PLAY CUSTOM SOUND
  const audio = new Audio(
    '/assets/audio/reminder_sound.mp3'
  );
  audio.volume = 1;

  audio.play().catch(err => {
    console.log('Audio blocked:', err);
  });

  // ðŸ”¥ SHOW NOTIFICATION
  const notification = new Notification(
    payload.data.title,
    {
      body: payload.data.body,
      icon: "/icon.png",
      requireInteraction: true,
      vibrate: [500, 300, 500]
    }
  );

  // ðŸ”¥ AUTO CLOSE AFTER 1 MIN
  setTimeout(() => {

    notification.close();

  }, 60000);
});
</script>



<script>
  async function initFCMAndSave() {
    try {
      const permission = await Notification.requestPermission();

      if (permission !== "granted") {
        console.log("Permission denied");
        showErrorToast("Please allow notifications for this site.");
        return;
      }

      // 🔥 get token
      const token = await messaging.getToken({
        vapidKey: "BPIivwK5UvRqr9ISiT_QcGbRFuM5xrUq_CYBkGqReGNFgWoS4aIWOuiLYJET7WouXj1wKSWPD145YIwXczs1VYo"
      });

      if (!token) {
        console.log("No token ❌");
        return;
      }

      console.log("Token:", token);

      // 🔥 get existing token from DB
       const existingToken = @json(optional(auth()->user())->fcm_token);

      // ✅ ONLY STORE IF NOT EXISTS
      if (existingToken) {
        console.log("Token already exists in DB ✅");
        return;
      }

      // 🔥 save token
      await fetch('/save-token', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          token: token
        })
      });

      console.log("Token stored successfully ✅");

    } catch (err) {
      console.log("FCM error:", err);
    }
  }

  // 🚀 run immediately
  initFCMAndSave();
</script>

<script>
  function showErrorToast(message) {

    const toast = document.createElement("div");

    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: rgba(244,63,94,.15);
        border: 1px solid rgba(244,63,94,.3);
        color: #f43f5e;
        padding: 14px 18px;
        border-radius: 10px;
        font-family: Arial, sans-serif;
        box-shadow: 0 6px 18px rgba(0,0,0,.15);
        z-index: 9999;
        transition: all .3s ease;
    `;

    toast.innerText = message;

    document.getElementById("toast-area").appendChild(toast);

    setTimeout(() => {
      toast.style.opacity = "0";
      toast.style.transform = "translateX(50px)";

      setTimeout(() => {
        toast.remove();
      }, 300);

    }, 3000);
  }
</script>

