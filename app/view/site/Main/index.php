<!DOCTYPE html>
<html lang="tw">
  <head>
    <meta http-equiv="Content-Language" content="zh-tw" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" />

    <title>Maple</title>
 
  </head>
  <body lang="zh-tw">
    <a href="https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=<?php echo config('line', 'channel', 'id'); ?>&redirect_uri=http://dev.shari.web.tw/api/line/auth/callback&scope=openid%20profile&state=abcde">點選這裡連結到LineLogin</a>
  </body>
</html>
