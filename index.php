<?php
    require_once(__DIR__.'/include/init.php');
    session_start();
    
    
    

   $url = baseURL();

    
   
    switch($url[4]){
        case "login":
            
            require_once(__DIR__.'/templates/login.php');
            break;
        case "signUp":
                require_once(__DIR__.'/templates/signUp.php');
                break;
        default:
            echo "json error message will be returned with status code of 404 and error message is url doesn't exist";
            break;
    }

?>