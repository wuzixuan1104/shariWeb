<!DOCTYPE html>
<html lang="tw">
  <head>
    <meta http-equiv="Content-Language" content="zh-tw" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" />

    <title>Maple</title>
 
  </head>
  <body lang="zh-tw">
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

      const messaging = firebase.messaging();

      messaging.requestPermission()
        .then(res => {
          // 若允許通知 -> 向 firebase 拿 token
          return messaging.getToken();
        }, err => {
          // 若拒絕通知
          console.log(err);  
        })
        .then(token => {
          // 成功取得 token
          // postToken(token); // 打給後端 api
          console.log(token);
        });
    </script>

  </body>
</html>
