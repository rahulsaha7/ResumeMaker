<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class resumes
{

    public $status;
    private $success;
    private $message;
    private $values;
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
        $this->sql = "SELECT   * from resume where userID = $this->id";

        $this->db->query($this->sql);
        if ($this->db->sql_query->rowCount() > 0) {
            $this->message = "resumes are here";
            $this->success = true;
            $this->values = $this->db->sql_query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $this->message = "Opps! looks like templates are gone somewhere";
            $this->success = false;
            $this->values = null;
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
