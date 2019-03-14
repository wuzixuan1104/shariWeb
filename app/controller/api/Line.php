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

    $obj = $obj->post('https://api.line.me/v1/oauth/accessToken', [
      'grant_type' => 'authorization_code',
      'client_id' => config('line', 'channel', 'id'),
      'client_secret' => config('line', 'channel', 'secret'),
      'code' => $code,
      'redirect_url' => 'http://dev.shari.web.tw/',
    ]);
    if (!$data = $obj->jsonBody) 
      gg('fail response !');

    echo $code;
    print_R($obj);
    die;
    if (!(isset($data['access_token']) && $data['access_token'])) 
      gg('fail get profile');

    $obj = new Curl();
    $obj = $obj->get('https://api.line.me/v1/profile', ['Authorization' => 'Bearer ' . $data['access_token']]);
    if (!$res = $obj->jsonBody)
      gg('fail response');

    if(!$user = \M\User::create(['name' => $res['displayName'], 'mid' => $res['mid'], 'accessToken' => $data['access_token']]))
      gg('fail');

    echo 'success';
    die;

  }
}