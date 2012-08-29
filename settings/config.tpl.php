<?php

// Misc
define('LOG_LEVEL', 0); // 0: log inactive, 1: log active

// App
define('PROTOCOL', (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http");
define('HOST_NAME', 'localhost');
define('RELATIVE_BASE_URL', '/noah');
define('BASE_URL', PROTOCOL.'://'.HOST_NAME.RELATIVE_BASE_URL);
define('BASE_PATH', realpath(dirname(__FILE__)).'/../');
define('UPLOADS_PATH', BASE_PATH.'/uploads');
 
// DB:
define('DB_HOST', 'localhost');
define('DB_NAME', 'mydb');
define('DB_USER', 'root');
define('DB_PASS', '');

