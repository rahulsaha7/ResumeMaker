<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';



class Mailer
{
    public $status;
    public $success;
    public $message;
    private $mail;



    public function cleanData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function sendMail($email, $otp)
    {
        try {
            $this->message = 'false';
            $this->mail = new PHPMailer(true);
            // $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $this->mail->isSMTP();
            $this->mail->SMTPAuth   = true;
            $this->mail->Host = 'smtp.sendgrid.net';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'apikey';
            $this->mail->Password = '';
            $this->mail->SMTPSecure = 'tls';
            $this->mail->Port = 587;
            $this->mail->setFrom('rsahagdrive@gmail.com');
            $this->mail->addAddress($email);

            $this->mail->isHTML(true);
            $this->mail->Subject = 'Easy Resume reset password request';
            ob_start();
            include 'templates/mailTemplate.php';
            $this->mail->AddEmbeddedImage('Assets/Images/easyresume.png', 'img2');
            $this->mail->AddEmbeddedImage('Assets/Images/adaptive-icon.png', 'img1');

            $this->mail->Body = ob_get_contents();

            ob_end_clean();


            $this->mail->AltBody = 'Body in plain text for non-HTML mail clients';
            $this->mail->send();
            $this->success = true;
            $this->message = "successfull";
        } catch (Exception $e) {
            $this->success = false;
            $this->message = "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
};

//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