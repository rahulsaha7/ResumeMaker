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
            $db = new database();
            $sql = "SELECT email from `auth` where email = '$email'";
            $db->query($sql);
            if ($db->sql_query->rowCount() > 0) {
                $db->query($sql);
                $this->mailer = new Mailer();

                $email = $this->mailer->cleanData($email);

                //generate otp send it to mail
                $otp =  mt_rand(100000, 999999);
                $img1 = file_get_contents('../Assets/Images/easyresume.png');
                $img1 = base64_encode($img1);
                $img2 = file_get_contents('../Assets/Images/adaptive-icon.png');
                $img2 = base64_encode($img2);
                $this->mailer->sendMail($email, $otp);
                $this->data = $this->mailer->success;
                //if message send is successfull then store that otp to database;
                if ($this->data) {

                    $sql = "UPDATE `auth` set  	OTP = $otp where email = '$email'";
                    $db->query($sql);
                    if ($db->sql_query->rowCount() > 0) {
                        $this->message = $this->mailer->message;
                    } else {
                        $this->data = false;
                        $this->message = "something went wrong at database";
                    }
                }
            } else {
                $this->data = false;
                $this->message = "email doesn't exist on our system";
            }


            $db->close_connection();
            $this->ResultReturn();
        }
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



$newforgot = new Forgot();
