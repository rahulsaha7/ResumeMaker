<?php


$env2 = 'lv';

if ($env2 == 'development') {





    defined('DB_HOST') ? NULL : define('DB_HOST', 'localhost');
    defined('DB_USER') ? NULL : define('DB_USER', 'root');
    defined('DB_PASS') ? NULL : define('DB_PASS', 'Rahul@7242');
    defined('DB_NAME') ? NULL : define('DB_NAME', 'MAD');
} else {

    defined('DB_HOST') ? NULL : define('DB_HOST', 'remotemysql.com');
    defined('DB_USER') ? NULL : define('DB_USER', '0ERaAydX2j');
    defined('DB_PASS') ? NULL : define('DB_PASS', 'CkPmhRmMuU');
    defined('DB_NAME') ? NULL : define('DB_NAME', '0ERaAydX2j');
}
