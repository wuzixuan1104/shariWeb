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
          <textarea name="content" required placeholder="請輸入內容"></textarea>
        </label>
        <label class="row">
          <input type="submit" value="送出">
        </label>
      </div>
    </form>
  </body>
</html>
