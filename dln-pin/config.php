<?php

$user_config = array (
  'product_info' => 
  array (
    'version' => '3.0',
    'build' => '0929',
  ),
  'vendors' => 
  array (
    0 => 'Taobao',
    1 => 'Sina',
    2 => 'Renren',
    3 => 'QQ',
    4 => 'Facebook',
    5 => 'Twitter',
  ),
  'optimizer' => 
  array (
    'gzip' => '0',
    'gzip_compression_level' => '9',
  ),
  'db' => 
  array (
    'host' => 'localhost',
    'port' => '3306',
    'login' => 'root',
    'password' => '',
    'database' => 'pinx',
    'prefix' => 'pin_',
  ),
  'bbs' => 
  array (
    'open' => '0',
    'driver' => 'mysqli',
    'host' => '',
    'port' => '3306',
    'login' => '',
    'password' => '',
    'database' => '',
    'prefix' => 'pre_',
    'persistent' => false,
  ),
  'ucenter' => 
  array (
    'UC_OPEN' => '0',
    'UC_DEBUG' => true,
    'UC_CONNECT' => 'mysqli',
    'UC_DBHOST' => 'localhost',
    'UC_DBUSER' => 'root',
    'UC_DBPW' => '',
    'UC_DBNAME' => '',
    'UC_DBCHARSET' => 'utf8',
    'UC_DBTABLEPRE' => 'bbs2.pre_ucenter_',
    'UC_DBCONNECT' => 0,
    'UC_CHARSET' => 'utf-8',
    'UC_KEY' => '123456',
    'UC_API' => 'http://localhost/bbs2/uc_server',
    'UC_APPID' => '2',
    'UC_IP' => '127.0.0.1',
    'UC_PPP' => 20,
  ),
  'lang' => 
  array (
    'default' => 'zh_cn',
    'en' => 'F:\\xampp\\htdocs\\pinx/lang/en/lang.php',
    'zh_cn' => 'F:\\xampp\\htdocs\\pinx/lang/zh_cn/lang.php',
  ),
  'email' => 
  array (
    'protocol' => 'mail',
    'from' => 'no-reply@pintuxiu.com',
    'sender' => '拼图秀',
    'smtp_host' => '',
    'smtp_user' => '',
    'smtp_pass' => '',
    'smtp_port' => '',
  ),
  'default_controller' => 'welcome',
);
