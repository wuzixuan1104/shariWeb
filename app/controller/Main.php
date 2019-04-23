<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class Main extends Controller {
  public function __construct() {
    Load::sysLib('Asset.php');
    Load::sysLib('Session.php');
    Load::sysLib('Validator.php');
  }

  public function index() {
    echo 'Hello World';
    $asset = Asset::create()
                ->addJS('/asset/js/res/jquery-1.10.2.min.js')
                ->addJS('/asset/js/site/Main/index.js');

    return View::create('site/Main/index.php')
                ->with('asset', $asset);
  }

  public function login() {
    $flash = Session::getFlashData('flash');

    $asset = Asset::create()
                  ->addCSS('/asset/css/icon-admin-login.css')
                  ->addCSS('/asset/css/admin/login.css')
                  ->addJS('/asset/js/res/jquery-1.10.2.min.js')
                  ->addJS('/asset/js/login.js');

    return View::create('site/Main/login.php')
               ->with('asset', $asset)
               ->with('flash', $flash);
  }

  public function signin() {
    wtfTo('MainLogin');

    $params = Input::post();
    
    validator(function() use (&$params, &$user) {
      Validator::need($params, 'account', '帳號')->isVarchar(190);
      Validator::need($params, 'password', '密碼')->isPassword();
      
      $user = \M\User::one('account = ?', $params['account']);
      $user || error('此帳號不存在！');

      password_verify($params['password'], $user->password) || error('密碼錯誤！');
    });

    transaction(function() use (&$user) {
      return $user->save();
    });

    Url::refreshWithSuccessFlash(Url::toRouter('MainIndex'), '登入成功！');
  }

  public function link() {
    wtfTo('MainLogin');

    $params = Input::post();
    
    validator(function() use (&$params, &$user) {
      Validator::need($params, 'account', '帳號')->isVarchar(190);
      Validator::need($params, 'password', '密碼')->isPassword();
      Validator::need($params, 'linkToken', 'LinkToken')->isVarchar(190);
      
      $user = \M\User::one('account = ?', $params['account']);
      $user || error('此帳號不存在！');

      password_verify($params['password'], $user->password) || error('密碼錯誤！');
      
      if($nonce = $this->randomNonce())
        $user->lid = $nonce;
    });

    transaction(function() use (&$user) {
      return $user->save();
    });

    Url::redirect('https://access.line.me/dialog/bot/accountLink?linkToken=' . $params['linkToken'] . '&nonce=' . $user->lid);
    return true;
  }

  public function randomNonce($length = 8) {
    $result = '';
    $chars = 'bcdfghjklmnprstvwxzaeiou';
    for ($p = 0; $p < $length; $p++)
      $result .= ($p%2) ? $chars[mt_rand(19, 23)] : $chars[mt_rand(0, 18)];
    return base64_encode($result);
  }
}
