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
  const title = payload.data.title;
  const options = {
    click_action: payload.data.click_action,
    icon: payload.data.icon,
    body: payload.data.body
  };
  
  const promiseChain = clients.matchAll({
    type: 'window',
    includeUncontrolled: true
  })
  .then(function(windowClients) {
    for (let i = 0; i < windowClients.length; i++) {
      const windowClient = windowClients[i];
      windowClient.postMessage(data);
    }
  })
  .then(function() {
    return registration.showNotification(title, options);
  });
  return promiseChain;

  // return self.registration.showNotification(title, options);
});

navigator.serviceWorker.addEventListener('message', function(event) {
  console.log('Received a message from service worker: ', event.data);
});


