<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class Liff extends ApiController {
  
  public function index() {
    $post = Input::post();
    return $post;
  }
  
}