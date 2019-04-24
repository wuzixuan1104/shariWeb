<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class Chat extends Controller {
  public function __construct() {
    Load::sysLib('Asset.php');
    Load::sysLib('Session.php');
    Load::sysLib('Validator.php');
  }

  public function index() {
    $asset = Asset::create()
                ->addJS('/asset/js/res/jquery-1.10.2.min.js')
                ->addJS('/asset/js/site/Main/index.js');

    return View::create('site/Main/index.php')
                ->with('asset', $asset);
  }
}