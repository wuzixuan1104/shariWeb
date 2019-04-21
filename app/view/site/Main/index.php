<!DOCTYPE html>
<html lang="tw">
  <head>
    <meta http-equiv="Content-Language" content="zh-tw" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" />
    <title>Maple</title>
    <script src="https://www.gstatic.com/firebasejs/5.10.0/firebase.js"></script>
    <script>
      // Initialize Firebase
      var config = {
        apiKey: "AIzaSyAKJ4shHKjGJJKSAYyeNLJLdy2UhxoHM4g",
        authDomain: "tripsaas-test.firebaseapp.com",
        databaseURL: "https://tripsaas-test.firebaseio.com",
        projectId: "tripsaas-test",
        storageBucket: "tripsaas-test.appspot.com",
        messagingSenderId: "612781458571"
      };
      firebase.initializeApp(config);
    </script>

  </head>
  <body lang="zh-tw">
    <script>
      const messaging = firebase.messaging();
      
      messaging.requestPermission().then(function() {
        console.log('Have permission');
        return messaging.getToken();
      })
      .then(function(token) {
        console.log(token);
      })
      .catch(function(err) {
        console.log('Error occurred!');
      });

      messaging.onMessage(function(payload) {
        console.log('onMessage:', payload);
      });

    </script>

  </body>
</html>
