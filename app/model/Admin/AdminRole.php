<?php

namespace M;

defined('MAPLE') || exit('此檔案不允許讀取！');

class AdminRole extends Model {
  // static $hasOne = [];

  // static $hasMany = [];

  // static $belongToOne = [];

  // static $belongToMany = [];

  // static $uploaders = [];

  const ROLE_ROOT    = 'root';
  const ROLE_ADMIN   = 'admin';

  const ROLE = [
    self::ROLE_ROOT => '最高權限', 
    self::ROLE_ADMIN => '後台管理者',
  ];
}
