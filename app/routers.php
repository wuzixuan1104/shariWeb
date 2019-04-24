<?php defined('MAPLE') || exit('此檔案不允許讀取！');

Router::get('')->controller('Main@index');
Router::get('login')->controller('Main@login');
Router::post('login')->controller('Main@signin');
Router::post('link')->controller('Main@link');

Router::get('liff')->controller('Liff@index');
Router::post('liff')->controller('Liff@post');

Router::get('chat/(id:num)')->controller('Chat@index');

Router::file('cli.php')   || gg('載入 Router「cli.php」失敗！');
Router::file('admin.php') || gg('載入 Router「admin.php」失敗！');
Router::file('api.php')   || gg('載入 Router「api.php」失敗！');
