<?php

//This file is in a making a progress 

class authCred   

{

    public $status;
    private $data;
    private $message;
    private $request;
    private $db;
    private $sql;
    private $values;
    private $result;
    private $sessionData=null;
   
    function __construct () {
        $this->request = $_SERVER['REQUEST_METHOD'];
        $this->request == 'GET' ? extract($_GET) : extract($_POST);
        
        // $email  = $this->cleanData($email);
        // $this->Login($email,$password);

            $this->showCredData();
        
    }

    function cleanData($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
      
      function showCredData () {


            $this->status = true;


           if(isset($_SESSION['authCredentials'])){
                $this->data = true;
                $this->message = "Auth data is retrieved";
                $this->sessionData = $_SESSION['authCredentials'];
           }else{
            $this->data = false;
            $this->message = "Session is not set";
           }

         $this->result = array(
            "status"=>$this->status,
            "data"=>$this->data,
            "message"=>$this->message,
            "SessionData"=>$this->sessionData
        );
        echo json_encode($this->result);

      }
};


$login = new authCred();
?>