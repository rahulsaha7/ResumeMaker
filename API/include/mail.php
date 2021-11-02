<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
  
require 'vendor/autoload.php';


class Mailer
{
    public $status;
    private $data;
    private $message;
    private $mail;

    

    public function cleanData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function sendMail($email)
    {
        try {
            $this->message = 'false';
            $this->mail = new PHPMailer(true);
            $this->mail->SMTPDebug = 2;
            $this->mail->isSMTP();
            $this->mail->SMTPAuth   = true;    
            $this->mail->Host = 'smtp.goggle.com;';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'rsahagdrive@gmail.com';
            $this->mail->Password = 'shinchan7242';
            $this->mail->SMTPSecure = 'tls';
            $this->mail->Port = 587;
            $this->mail->setFrom('rsahagdrive@gmail.com', 'Esay Resume');
            $this->mail->addAddress($email);

            $this->mail->isHTML(true);
            $this->mail->Subject = 'Easy Resume forgot password';
            $this->mail->Body = 'HTML message body in <b>mail for forgot password</b> ';
            $this->mail->AltBody = 'Body in plain text for non-HTML mail clients';
            $this->mail->send();
            $this->data = true;
            $this->message = "successfull";

        } catch (Exception $e) {
            $this->data = false;
            $this->message = "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }

};
