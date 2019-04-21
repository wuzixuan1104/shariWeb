importScripts('https://www.gstatic.com/firebasejs/4.5.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/4.5.2/firebase-messaging.js');

var config = {
        apiKey: "AIzaSyAKJ4shHKjGJJKSAYyeNLJLdy2UhxoHM4g",
        authDomain: "tripsaas-test.firebaseapp.com",
        databaseURL: "https://tripsaas-test.firebaseio.com",
        projectId: "tripsaas-test",
        storageBucket: "tripsaas-test.appspot.com",
        messagingSenderId: "612781458571"
      };
      
firebase.initializeApp(config);

const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  const notificationTitle = 'Background Message Title';
  const notificationOptions = {
    body: 'Background Message body.',
    icon: '/firebase-logo.png'
  };

  return self.registration.showNotification(notificationTitle,
      notificationOptions);
});