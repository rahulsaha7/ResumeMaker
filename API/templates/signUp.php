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
    private $sessionData = null;
    private $id;
    public $date;

    public function __construct()
    {
        $this->status = http_response_code();
        $this->request = $_SERVER['REQUEST_METHOD'];

        $this->request == 'GET' ? extract($_GET) : extract($_POST);

        //This line of code checck if any empty data is send by client

        if (!isset($email) || !isset($username) || !isset($phone) || !isset($password) || empty($username) || empty($email) || empty($phone) || empty($password)) {

            $this->data = false;

            if (!isset($email) || empty($email)) {
                $this->message = 'Email field shold not be empty';
            } else if (!isset($phone) || empty($phone)) {
                $this->message = 'phone field shold not be empty';
            } else if (!isset($password) || empty($password)) {
                $this->message = 'Password field  shold not be empty';
            } else if (!isset($username) || empty($username)) {
                $this->message = 'name field shold not be empty';
            } else {
                $this->message = "Looks like some data is empty";
            }
            $this->ResultReturn();

        } else {
            $email = $this->cleanData($email);
            $username = $this->cleanData($username);
            $phone = $this->cleanData($phone);

            $this->id = strtotime('now');
            
            $this->date = date("Y-m-d", strtotime("now"));
            $password = password_hash($password, PASSWORD_BCRYPT);
            $this->values = array($this->id, $username, $email, $phone, $password, $this->date);
            $this->register();
        }

    }

    public function cleanData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    private function register()
    {

        $email = $this->values[2];
        $this->sql = "SELECT userID from auth where email = '$email'";

        $this->db = new database();
        $this->db->query($this->sql);
        if ($this->db->sql_query->rowCount() > 0) {
            $this->status = true;
            $this->data = false;
            $this->message = "Username already exist";
        } else {

            $this->sql = "INSERT into auth (userID,name,email,phone,password,joinDate) values(?,?,?,?,?,?)";
            $this->db->query_value($this->sql, $this->values);
            if ($this->db->sql_query->rowCount() > 0) {

                $this->data = true;
                $this->message = "Registration Successfull";
                $this->sessionData = array('SessionID' => session_id(), 'userId' => $this->values[0], 'username' => $this->values[2]);
                $_SESSION['authCredentials'] = $this->sessionData;

            } else {
                $this->data = false;
                $this->message = "Error occured";
            }

        }

        $this->ResultReturn();

        $this->db->close_connection();

    }

    private function ResultReturn()
    {
        $this->result = array(
            "status" => $this->status,
            "data" => $this->data,
            "message" => $this->message,
            "SessionData" => $this->sessionData,
        );
        echo json_encode($this->result);
    }

};

$newReg = new Signup();
