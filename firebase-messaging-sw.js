importScripts('https://www.gstatic.com/firebasejs/5.10.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/5.10.0/firebase-messaging.js');

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
    body: payload.data.body,
    data: payload.data
  };

  return self.registration.showNotification(title, options);
});

self.addEventListener('notificationclick', function(event) {
  const pageUrl = event.notification.data.click_action;

  const urlToOpen = new URL(pageUrl, self.location.origin).href;

  const promiseChain = clients.matchAll({
    type: 'window',
    includeUncontrolled: true
  })
  .then((windowClients) => {
    let matchingClient = null;

    for (let i = 0; i < windowClients.length; i++) {
      const windowClient = windowClients[i];
      if (windowClient.url === urlToOpen) {
        matchingClient = windowClient;
        break;
      }
    }

    if (matchingClient) {
      return matchingClient.focus();
    } else {
      return clients.openWindow(urlToOpen);
    }
  });

  event.waitUntil(promiseChain);
});







