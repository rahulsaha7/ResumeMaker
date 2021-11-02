<?php

//This file is in a making a progress

class authCred
{

    public $status;
    private $data;
    private $message;
    private $request;
    private $s_id;
    private $values;
    private $result;
    private $sessionData = null;

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
        $this->request == 'GET' ? extract($_GET) : extract($_POST);

        $session_id = $this->cleanData($session_id);
        // $this->Login($email,$password);

        $this->showCredData($session_id);

    }

    public function cleanData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function showCredData($session_id)
    {

        $this->status = http_response_code();

        $this->s_id = session_id();

        if (isset($_SESSION['authCredentials']) || !empty($this->s_id) || $this->s_id == $session_id) {
            $this->data = true;
            $this->message = "Auth data is retrieved";
            $this->sessionData = $_SESSION['authCredentials'];
        } else {
            $this->data = false;
            $this->message = "Session is not set or expired";
        }

        $this->result = array(
            "status" => $this->status,
            "data" => $this->data,
            "message" => $this->message,
            "SessionData" => $this->sessionData,
        );
        echo json_encode($this->result);

    }
};

$login = new authCred();
