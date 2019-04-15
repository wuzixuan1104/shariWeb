<!DOCTYPE html>
<html lang="zh-Hant">
  <head>
    <meta http-equiv="Content-Language" content="zh-tw">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>信件內容</title>

    <?php echo $asset->renderCSS ();?>
    <?php echo $asset->renderJS ();?>

  </head>
  <body>
    <form class="login_form">
      <div class="list">
        <label class="row">
          <textarea id="myTextarea" name="content" required placeholder="請輸入內容"></textarea>
        </label>
        <label class="row">
          <input id="getProfile" type="button" value="取得使用者資料">
          <input id="send" type="submit" value="送出">
        </label>
      </div>
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
            liff.closeWindow();
        });

        document.getElementById('getProfile').addEventListener('click', function () {
            liff.getProfile().then(function (profile) {
                var html = 'user_id = ' + profile.userId + '<br>';
                html += 'display_name = ' + profile.displayName;
                document.getElementById('myTextarea').value = html;
                
            }).catch(function (error) {
                window.alert("Error getting profile: " + error);
            });
        });
      }


    </script>
  </body>
</html>
