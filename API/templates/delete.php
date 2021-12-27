<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class resumes
{

    public $status;
    private $success;
    private $message;
    private $values = [];
    private $db;
    private $sql;
    private $result;
    private $id;

    public function __construct()
    {


        try {

            $bearerToken = $_SERVER['HTTP_AUTHORIZATION'];
            if ($bearerToken) {


                //If token is there then verify first then use it

                $decode = JWT::decode($bearerToken, new Key('bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew', 'HS256'));
                $this->request = $_SERVER['REQUEST_METHOD'];
                $this->request == 'GET' ? extract($_GET) : extract($_POST);
                if (isset($resumeNo)) {
                    $this->deleteResume($resumeNo);
                } else {
                    $this->success = false;
                    $this->message = "resumeno is missing";
                }
            } else {
                $this->success = false;
                $this->message = "Token is missing";
            }
        } catch (Exception $e) {

            $this->message =  $e->getMessage();
        } finally {
            $this->ResultReturn();
        }
    }



    public function deleteResume($resumeNo)
    {

        $this->db = new database();



        $this->sql = " DELETE FROM `resume` WHERE `resume`.resumeNo = $resumeNo";
        $this->db->query($this->sql);
        if ($this->db->sql_query->rowCount() > 0) {



            $this->message = "Resume deleted";
            $this->success = true;
        } else {
            $this->message = "no resume found for this resumeNo";
            $this->success = false;
        }
    }

    private function ResultReturn()
    {

        $this->result = array(
            "success" => $this->success,
            "message" => $this->message,
        );
        echo json_encode($this->result);
    }
};

$login = new resumes();
