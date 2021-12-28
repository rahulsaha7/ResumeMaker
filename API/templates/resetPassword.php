<?php




class Reset
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

        if (!isset($password) || empty($password)) {

            $this->data = false;
            $this->message = 'password must not be empty';
            $this->ResultReturn();
        } else if (!isset($email) || empty($email)) {
            $this->data = false;
            $this->message = 'email must be there';
            $this->ResultReturn();
        } else {

            $hasPassword = password_hash($password, PASSWORD_BCRYPT);
            $db = new database();
            $sql = "UPDATE `auth` set  	password = '$hasPassword' where email = '$email'";

            $db->query($sql);
            if ($db->sql_query->rowCount() > 0) {
                $this->data = true;
                $this->message = "Password updated";
            } else {
                $this->data = false;
                $this->message = "email doesn't exist on our system";
            }
        }



        $db->close_connection();
        $this->ResultReturn();
    }


    private function ResultReturn()
    {
        $this->result = array(
            "status" => $this->status,
            "success" => $this->data,
            "message" => $this->message
        );
        echo json_encode($this->result);
    }
};



$newforgot = new Reset();
