<?php




class Verify
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

        if (!isset($otp) || empty($otp)) {

            $this->data = false;
            $this->message = 'unique otp must be there';
            $this->ResultReturn();
        } else if (!isset($email) || empty($email)) {
            $this->data = false;
            $this->message = 'email must be there';
            $this->ResultReturn();
        } else {



            //if message send is successfull then store that otp to database;

            $db = new database();
            $sql = "SELECT OTP from `auth` where email = '$email'";
            $db->query($sql);
            if ($db->sql_query->rowCount() > 0) {
                $result = $db->sql_query->fetchAll(PDO::FETCH_ASSOC);
                if ($otp == $result[0]['OTP']) {
                    $this->data = true;
                    $this->message = "otp matched";
                } else {
                    $this->data = false;
                    $this->message = "otp missmatched";
                }
            } else {
                $this->data = false;
                $this->message = "email not found";
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



$newforgot = new Verify();
