<!DOCTYPE html>
<html lang="tw">
  <head>
    <meta http-equiv="Content-Language" content="zh-tw" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" />
    <title>Firebase 推播</title>
    <script src="https://www.gstatic.com/firebasejs/5.10.0/firebase.js"></script>
    <?php echo $asset->renderCSS(); ?>
    <?php echo $asset->renderJS(); ?>
  </head>
  <body lang="zh-tw">
      <header class="header">
        <div class="title">Shari's Notification</div>        
      </header>
      <div class="container">

        <label>目前的推播 Token</label>
        <div class="content">Can't get any token ...</div>

        <span class="hr"></span>

        <form>
          <input name="title" type="text" placeholder="請輸入標題">
          <input name="body" type="text" placeholder="請輸入內容">
        <button class="send">發送一則推播給自己</button>

        </form>
      </div>
  </body>
</html>
