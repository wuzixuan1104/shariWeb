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
          const notificationTitle = payload.data.title;
          const notificationOptions = {
              body: payload.data.status,
              icon: payload.data.icon,        
          };

          if (!("Notification" in window)) {
              console.log("This browser does not support system notifications");
          }
          // Let's check whether notification permissions have already been granted
          else if (Notification.permission === "granted") {
              // If it's okay let's create a notification
              var notification = new Notification(notificationTitle,notificationOptions);
              notification.onclick = function(event) {
                  event.preventDefault(); // prevent the browser from focusing the Notification's tab
                  window.open(payload.data.click_action , '_blank');
                  notification.close();
              }
          }
      });

      /* realtime */
    
      // var datetime = new Date(new Date().toString().split('GMT')[0]+' UTC').toISOString().split('.')[0].replace('T',' ');

      // firebase.database().ref('cs/1').set({
      //   date: datetime,
      // });

      
      var csRef = firebase.database().ref('cs/1');
      console.log(csRef);

      csRef.on('value', function(snapshot) {

        var key = snapshot.key;
        console.log('key:', key);
        console.log(snapshot.val());
      });

    </script>

  </body>
</html>
