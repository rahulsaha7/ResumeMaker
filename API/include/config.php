<?php


$env2 = 'development';

if ($env2 == 'production') {




    defined('BASE_URL') ? NULL : define('BASE_URL', 'http://localhost');
    defined('DB_HOST') ? NULL : define('DB_HOST', 'localhost');
    defined('DB_USER') ? NULL : define('DB_USER', 'root');
    defined('DB_PASS') ? NULL : define('DB_PASS', '');
    defined('DB_NAME') ? NULL : define('DB_NAME', 'MAD');
} else {
    defined('BASE_URL') ? NULL : define('BASE_URL', '');
    defined('DB_HOST') ? NULL : define('DB_HOST', 'roundhouse.proxy.rlwy.net');
    defined('DB_USER') ? NULL : define('DB_USER', 'root');
    defined('DB_PASS') ? NULL : define('DB_PASS', 'CeAHfd6F5daehDacaFbbcbCAGe6C6BDd');
    defined('DB_NAME') ? NULL : define('DB_NAME', 'railway');
}
