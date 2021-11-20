<?php

use Firebase\JWT\JWT;

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
    private $payload;
    private $secretCode;
    private $jwt;
    private $issuedAt;
    private $expire;
    private $id;
    public $date;

    public function __construct()
    {
        $this->status = http_response_code();
        $this->request = $_SERVER['REQUEST_METHOD'];

        $this->request == 'GET' ? extract($_GET) : extract($_POST);

        //This line of code checck if any empty data is send by client

        if (!isset($email)  || !isset($phone) || !isset($password) || empty($email) || empty($phone) || empty($password)) {

            $this->data = false;

            if (!isset($email) || empty($email)) {
                $this->message = 'Email field shold not be empty';
            } else if (!isset($phone) || empty($phone)) {
                $this->message = 'phone field shold not be empty';
            } else if (!isset($password) || empty($password)) {
                $this->message = 'Password field  shold not be empty';
            } else {
                $this->message = "Looks like some data is empty";
            }
            $this->ResultReturn();
        } else {
            $email = $this->cleanData($email);
            $phone = $this->cleanData($phone);

            $this->id = strtotime('now');

            $this->date = date("Y-m-d", strtotime("now"));
            $password = password_hash($password, PASSWORD_BCRYPT);
            $this->values = array($this->id, $name, $email, $phone, $password, $this->date);
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
            $this->message = "Email is  already in use";
        } else {

            $this->sql = "INSERT into auth (userID,name,email,phone,password,joinDate) values(?,?,?,?,?,?)";
            $this->db->query_value($this->sql, $this->values);
            if ($this->db->sql_query->rowCount() > 0) {

                $this->data = true;
                $this->message = "Registration Successfull";
                $this->secretCode = "bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew";
                $this->issuedAt   = new DateTimeImmutable();
                $this->expire     = $this->issuedAt->modify('+1 minutes')->getTimestamp();
                $this->payload = array(
                    'iat'  => $this->issuedAt->getTimestamp(),         // Issued at: time when the token was generated
                    'nbf'  => $this->issuedAt->getTimestamp(),
                    'exp'  => $this->expire,
                    'userId' => $this->values[0],
                    'username' => $this->values[2]
                );
                $this->jwt = JWT::encode($this->payload, $this->secretCode, 'HS256');
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
            "token" => $this->jwt,
        );
        echo json_encode($this->result);
    }
};

$newReg = new Signup();
