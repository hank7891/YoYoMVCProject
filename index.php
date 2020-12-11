<?php
// 應用目錄為當前目錄
define('APP_PATH', __DIR__ . '/');

// 開啟除錯模式
define('APP_DEBUG', true);

// 載入框架檔案
require APP_PATH . 'fastphp/Fastphp.php';
require APP_PATH . 'fastphp/Controller.class.php';
require APP_PATH . 'fastphp/Sql.class.php';
require APP_PATH . 'fastphp/Model.class.php';
require APP_PATH . 'fastphp/View.class.php';




// 載入配置檔案
$config = require APP_PATH . 'config/config.php';

// 例項化框架類
(new Fastphp($config))->run();
