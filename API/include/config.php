<?php


$env2 = 'development';

if ($env2 == 'development') {




    defined('BASE_URL') ? NULL : define('BASE_URL', 'http://localhost');
    defined('DB_HOST') ? NULL : define('DB_HOST', 'localhost');
    defined('DB_USER') ? NULL : define('DB_USER', 'root');
    defined('DB_PASS') ? NULL : define('DB_PASS', 'Rahul@7242');
    defined('DB_NAME') ? NULL : define('DB_NAME', 'MAD');
} else {
    defined('BASE_URL') ? NULL : define('BASE_URL', 'https://www.maldanattyasena.xyz');
    defined('DB_HOST') ? NULL : define('DB_HOST', 'localhost');
    defined('DB_USER') ? NULL : define('DB_USER', 'maldanat_easyresume');
    defined('DB_PASS') ? NULL : define('DB_PASS', 'easyresume');
    defined('DB_NAME') ? NULL : define('DB_NAME', 'maldanat_downtimealert');
}
