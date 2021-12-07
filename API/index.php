<?php

declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/include/init.php';








session_start();
error_reporting(0);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: token, Content-Type');

class index
{

    private $url;
    private $SwitchURL;
    private $env;
    public $errorResponse;

    public function __construct()
    {
        $this->url = baseURL();
        $this->env = 'development';
        if ($this->env == 'development') {
            $this->SwitchURL = $this->url[6];
        } else {
            $this->SwitchURL = $this->url[4];
        }

        $this->route();
    }



    public function route()
    {
        switch ($this->SwitchURL) {
            case 'login':


                require_once __DIR__ . '/templates/login.php';

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

            case 'dashboard':

                require_once __DIR__ . '/templates/dashboard.php';
                break;

            case 'template':
                require_once __DIR__ . '/templates/template.php';
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
