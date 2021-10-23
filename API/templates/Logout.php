<?php

    class Logout {

        public $status;
        private $data;
        private $message;
        private $result;

        function __construct(){
            $this->unsetSession();     
        }

        function unsetSession(){
            $this->status = true;
            if(isset($_SESSION['authCredentials'])){
                unset($_SESSION['authCredentials']);
                $this->data = true;
                $this->message = "Logout successfull";
            }else{
                $this->data = false;
                $this->message = "Session is not set";
            }

            $this->result = array(
                
                "status"=>$this->status,
                "data"=>$this->data,
                "message"=>$this->message,
            );
            echo json_encode($this->result);
        }

    };
    
    $logOut = new Logout();
?>