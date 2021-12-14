<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class authCred
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



        $this->showTemplates();

        $this->ResultReturn();
    }



    public function showTemplates()
    {

        $this->db = new database();
        $this->sql = "SELECT * from template_master where 1";

        $this->db->query($this->sql);
        if ($this->db->sql_query->rowCount() > 0) {
            $this->message = "templates are here";
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

$login = new authCred();
