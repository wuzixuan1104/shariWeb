<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class Main extends Controller {
  public function index() {
    // Load::lib('Jwt.php');
    // $jwt = Jwt::create(['aud' => config('line', 'channel', 'id'), 'sub' => '123'], config('line', 'channel', 'secret'));
    // if (!$res = Jwt::decodeIdToken($jwt, config('line', 'channel', 'secret'), config('line', 'channel', 'id'), config('other', 'baseUrl')))
    //   gg('jwt token invalid !');

    // echo 'success';
    // die;
    return View::create('site/Main/index.php');
  }
}
