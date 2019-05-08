<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class Chat extends Controller {
  public function __construct() {
    Load::sysLib('Asset.php');
    Load::sysLib('Session.php');
    Load::sysLib('Validator.php');
  }

  public function index() {
    $asset = Asset::create()
                ->addCSS('/asset/css/site/Chat/index.css')
                ->addJS('/asset/js/res/jquery-1.10.2.min.js')
                ->addJS('/asset/js/site/Chat/index.js');

    return View::create('site/Chat/index.php')
                ->with('asset', $asset);
  }
}