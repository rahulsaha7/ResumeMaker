<?php
    
    


    class login
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
            
            $email  = $this->cleanData($email);
            $this->Login($email,$password);
            
        }

        function cleanData($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
          
          function Login ($email,$password) {
                $this->values = array($email);
                $this->sql = "SELECT id,email,password from auth where email = ?";
                $this->db = new database();
                $this->db->query_value($this->sql,$this->values);
                $this->status = true;
                if($this->db->sql_query->rowCount() > 0){
                    
                    $this->result = $this->db->sql_query->fetchAll(PDO::FETCH_ASSOC);
                   if(password_verify($password,$this->result[0]['password'])){
                       $this->data = true;
                       $this->message = "Login Successfull";
                        $this->sessionData = array('userId'=>$this->result[0]['id'],'username'=>$this->result[0]['email']);
                       $_SESSION['authCredentials'] = $this->sessionData;

                   }else{
                    $this->data = false;
                    $this->message = "Password Missmatched";
                   }
                    
             }
             else{
                $this->data = false;
                $this->message = "username doesn't exixst";
             }

             $this->result = array(
                "status"=>$this->status,
                "data"=>$this->data,
                "message"=>$this->message,
                "SessionData"=>$this->sessionData
            );
            echo json_encode($this->result);
            $this->db->close_connection();

          }
    };
    

    $login = new login();

    

?>