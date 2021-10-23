<?php
    defined('DS') ? NULL : define('DS',DIRECTORY_SEPARATOR);
    defined('BASE_DIR') ? null : define('BASE_DIR', 'http://localhost/MAD');
    defined('LIB_PATH') ? null : define('LIB_PATH',BASE_DIR.DS.'include/');
    defined('PAGE_PATH') ? null : define('PAGE_PATH',BASE_DIR.DS.'templates/');
    // defined('PAGE_PATH2') ? null : define('PAGE_PATH2','localhost/Studentpa_m');
    require_once("config.php");
	require_once("db.php");
    require_once('functions.php');
?>