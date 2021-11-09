<?php

require_once __DIR__ . '/include/init.php';
session_start();
error_reporting(true);
error_reporting(-1);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: token, Content-Type');

class index
{

    private $url;
    public $errorResponse;

    public function __construct()
    {
        $this->url = baseURL();

        $this->route();
    }

    public function route()
    {
        switch ($this->url[4]) {
            case 'login':
                
                
                require_once __DIR__. '/templates/login.php';

                break;

            case "signUp":

                require_once __DIR__ . '/templates/signUp.php';
                break;

            case 'auth-cred':

                require_once __DIR__ . '/templates/authCred.php';
                break;
            case "Logout":

                require_once __DIR__ . '/templates/Logout.php';
                break;
            case 'forgot-password':

                require_once __DIR__ . '/templates/forgot.php';
                break;

            case 'dashboard-data':

                    require_once __DIR__.'/templates/dashboard.php';
                    break;
                    
            default:
                $result = array(
                    'Status' => http_response_code(),
                    'error' => true,
                    "message" => "Link is not valid",
                );
                echo json_encode($result);
                break;
        }
    }

};

$index = new index();

?>