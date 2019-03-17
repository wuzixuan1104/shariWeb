<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class Line extends ApiController {
  
  public function __construct() {
    parent::__construct();
  }

  public function authCallback() {
    if(!$code = Input::get('code')) 
      gg('fail');  

    Load::lib('Curl.php');
    $obj = new Curl();

    $obj = $obj->post('https://api.line.me/oauth2/v2.1/token', [
      'grant_type' => 'authorization_code',
      'client_id' => config('line', 'channel', 'id'),
      'client_secret' => config('line', 'channel', 'secret'),
      'code' => $code,
      'redirect_uri' => 'http://dev.shari.web.tw/api/line/auth/callback',
    ], ['Content-Type: application/x-www-form-urlencoded']);

    if (!$data = $obj->jsonBody) 
      gg('fail response !');

    Load::lib('Jwt.php');

    if (!$res = Jwt::decodeIdToken($data['id_token'], config('line', 'channel', 'secret'), config('line', 'channel', 'id'), 'https://access.line.me'))
      gg('jwt token invalid !');
   
    if(!$user = \M\User::create(['name' => $res['name'], 'lid' => $res['sub'], 'jwtToken' => $data['id_token']]))
      gg('fail');

    // redirect();
    return true;
  }
}