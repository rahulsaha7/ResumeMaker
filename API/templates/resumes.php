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
                $this->id = $decode->userId;


                $this->showTemplates();
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



    public function showTemplates()
    {

        $this->db = new database();
        $this->sql = "SELECT resumeNo from resume where userID = $this->id";

        $this->db->query($this->sql);
        if ($this->db->sql_query->rowCount() > 0) {
            $this->message = "resumes are here";
            $this->success = true;
            $result = $this->db->sql_query->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $value) {
                $resume = $value['resumeNo'];
                $this->sql = "SELECT name,email,image,r.resumeNo from resume r,PersonalDetails p where r.resumeNo = p.resumeNo and  r.resumeNo = $resume";
                $this->db->query($this->sql);
                if ($this->db->sql_query->rowCount() > 0) {


                    $check = $this->db->sql_query->fetchAll(PDO::FETCH_ASSOC);

                    array_push($this->values, $check[0]);
                }
            }
        } else {
            $this->message = "you havn't created any resume";
            $this->success = true;
            $this->values = [];
        }
    }

    private function ResultReturn()
    {

        $this->result = array(
            "success" => $this->success,
            "message" => $this->message,
            "data" => $this->values,
        );
        echo json_encode($this->result);
    }
};

$login = new resumes();
