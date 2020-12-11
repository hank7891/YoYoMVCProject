<?php
// 資料庫配置
define('DB_NAME', 'yoyo_project');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', 'localhost');

// 預設控制器和操作名
$config['defaultController'] = 'Item';
$config['defaultAction'] = 'index';

$config['db'] = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => 'root',
    'dbname' => 'yoyo_project',
];

return $config;
// 入口中的$config變數接收到配置引數後，再傳給框架的核心類，也就是Fastphp類。