<!DOCTYPE html>
<html lang="zh-Hant">
  <head>
    <meta http-equiv="Content-Language" content="zh-tw">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no,minimal-ui">

    <title>請填寫表單</title>

    <?php echo $asset->renderCSS ();?>
    <?php echo $asset->renderJS ();?>

  </head>
  <body>
    <form class="login_form">
      <div class="list">
        <label class="row">
          <b>帳號</b>
          <input type="text" name="account" required>
        </label>
        <label class="row">
          <b>密碼</b>
          <input type="password" name="password" required>          
        </label>
        <label class="row">
          <input type="submit" value="送出">
        </label>
      </div>
    </form>
  </body>
</html>
