<?php


require_once 'include/mail.php';


class Forgot
{
    public $status;
    private $data;
    private $message;
    private $request;
    private $mailer;
    private $result;

    public function __construct()
    {
        $this->status = http_response_code();
        $this->request = $_SERVER['REQUEST_METHOD'];

        $this->request == 'GET' ? extract($_GET) : extract($_POST);

        //This line of code checck if any empty data is send by client

        if (!isset($email) || empty($email)) {

            $this->data = false;
            $this->message = 'Email must not be empty';
            $this->ResultReturn();

        } else {
            $this->mailer = new Mailer();
            
            $email = $this->mailer->cleanData($email);
            echo $email;
            $this->mailer->sendMail($email);
            $this->data = $this->mailer->data;
            $this->message = $this->mailer->message;
            $this->ResultReturn();
        }

    }

    private function ResultReturn()
    {
        $this->result = array(
            "status" => $_POST,
            "data" => $this->data,
            "message" => $this->message
        );
        echo json_encode($this->result);
    }

};


$newforgot = new Forgot();
