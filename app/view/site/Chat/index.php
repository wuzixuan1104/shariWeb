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
        <div class="content">d-rcxQmVXjo:APA91bEQIc2bJQPtm-xNiSAA3Lz6YhZniwX67-_Bff_yOJl9ASgxP8V2eMZsQz9HN7rPQvvlBOYw4hzV3fPsdkTXCRtBLd8lJ1rNtyP5Z0OBeOcIB5n7TH21vNtgdpEGcY4UtnQKmq9a</div>
        <button>發送一則推播給自己</button>

      </div>
  </body>
</html>
