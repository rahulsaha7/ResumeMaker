<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Forgot
{
    public $status;
    private $success;
    private $message;
    private $request;
    private $db;
    private $sql;

    private $result;
    private $id;
    private $Data = [];

    public function __construct()
    {

        $this->status = http_response_code();
        $this->request = $_SERVER['REQUEST_METHOD'];

        $this->request == 'GET' ? extract($_GET) : extract($_POST);

        //This line of code checck if any empty data is send by client
        try {

            $bearerToken = $_SERVER['HTTP_AUTHORIZATION'];
            if ($bearerToken) {



                $decode = JWT::decode($bearerToken, new Key('bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew', 'HS256'));
                $this->id = $decode->userId;
                $this->showDashData();
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


    private function showDashData()
    {

        $this->db = new Database();


        $this->sql = "SELECT resumeNo from  resume where userId = $this->id";
        $this->db->query($this->sql);
        if ($this->db->sql_query->rowCount() > 0) {
            $this->result = $this->db->sql_query->fetchAll(PDO::FETCH_ASSOC);

            $this->getPersonalData();
            $this->success = true;
            $this->message = "data fetched";
        } else {

            $this->success = false;
            $this->message = "This user haven't create a resume";
        }
        $this->db->close_connection();
    }

    private function getPersonalData()
    {

        // while ($this->result) {
        //     echo "resume no = " . $this->result['resumeNo'];
        // }

        for ($i = 0; $i < count($this->result); $i++) {

            $resumeNo = $this->result[$i]['resumeNo'];
            $this->sql = "SELECT id,name,email,image from PersonalDetails where resumeNo = $resumeNo ";
            $this->db->query($this->sql);
            if ($this->db->sql_query->rowCount() > 0) {
                $rsData =  $this->db->sql_query->fetchAll(PDO::FETCH_ASSOC);
                array_push($this->Data, $rsData);
            }
        }
    }




    private function ResultReturn()
    {
        $this->result = array(
            "status" => $this->status,
            "success" => $this->success,
            "message" => $this->message,
            "data" => $this->Data
        );
        echo json_encode($this->result);
    }
};


$newforgot = new Forgot();
