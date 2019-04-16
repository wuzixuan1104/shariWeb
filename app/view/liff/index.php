
  <head>
    <meta http-equiv="Content-Language" content="zh-tw">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">

    <title>信件內容</title>
    <link href="https://trip.web.shari.tw/asset/css/liff/index.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <form class="login_form">
      <div class="top">
        <!-- <div id="pic"><img src="/asset/img/me.png"></div> -->
        <div id="pic"></div>
        <span id="name">Shari</span>
      </div>
      <textarea id="myTextarea" name="content"  placeholder="請輸入內容" required></textarea>
      <input id="send" type="submit" value="送出">
    </form>

    <script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
    <script>
      window.onload = function (e) {
        liff.init(function (data) {
          initializeApp(data);
        });
      };

      function initializeApp(data) {
        document.getElementById('send').addEventListener('click', function () {
          if (document.getElementById('myTextarea').value == '')
            return false;

          liff.closeWindow();
        });

        liff.getProfile().then(function (profile) {
          document.getElementById('name').html = profile.displayName;

          const pictureDiv = document.getElementById('pic');
          const img = document.createElement('img');
          img.src = profile.pictureUrl;
          img.alt = "Profile Picture";
          pictureDiv.appendChild(img);

        }).catch(function (error) {
          window.alert("Error getting profile: " + error);
        });
      }
    </script>
  </body>

