<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class Liff extends Controller {
  public function __construct() {
    Load::sysLib('Asset.php');
    Load::sysLib('Session.php');
    Load::sysLib('Validator.php');
  }

  public function index() {
    $asset = Asset::create()
                  ->addCSS('/asset/css/liff/index.css')
                  ->addJS('/asset/js/res/jquery-1.10.2.min.js');

    return View::create('liff/index.php')
                    ->with('asset', $asset);
  }

  public function post() {

  }
}