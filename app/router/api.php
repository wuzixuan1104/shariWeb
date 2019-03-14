<?php defined('MAPLE') || exit('此檔案不允許讀取！');

Router::dir('api', function() {
  Router::get('line/auth/callback')->controller('Line@authCallback');
});