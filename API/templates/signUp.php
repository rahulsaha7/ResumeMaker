<?php

//Modify Everything in basis of class 
// now test it using normal functional way but transfer it class componenet later.

//return json data with accurate formatting and with status code for every type like success or error;


//tomorrow create private empty repo and push this login data to remp with proper call formatting



class Signup
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
    private $id;
    public $date;

    function __construct () {
        $this->request = $_SERVER['REQUEST_METHOD'];
        $this->request == 'GET' ? extract($_GET) : extract($_POST);

        $email  = $this->cleanData($email);
        $f_name = $this->cleanData($f_name);
        $phone = $this->cleanData($phone);

        $this->id = strtotime('now');
        $this->date = date("Y-m-d", strtotime("now"));
        $password = password_hash($password,PASSWORD_BCRYPT);
        $this->values = array($this->id,$f_name,$email,$phone,$password,$this->date);
        $this->register();
    }

    function cleanData ($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function register(){
            
            $email = $this->values[2];
            $this->sql = "SELECT id from auth where email = '$email'";
          
            $this->db = new database();
            $this->db->query($this->sql);
            if($this->db->sql_query->rowCount() > 0){
                $this->status = true;
                $this->data = false;
                $this->message = "Username already exist";
            }else{
                
                
               
                 $this->sql = "INSERT into auth (id,name,email,phone,password,joinDate) values(?,?,?,?,?,?)";
                 $this->db->query_value($this->sql,$this->values);
                 if($this->db->sql_query->rowCount() > 0){
                     $this->status = true;
                     $this->data = true;
                     $this->message = "Registration Successfull";
                     $this->sessionData = array('userId'=>$this->values[0],'username'=>$this->values[2]);   
                     $_SESSION['authCredentials'] = $this->sessionData;
                 }else{
                        $this->data = false;
                        $this->message = "Error occured";
                 }

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

$newReg = new Signup();





?>