<?php


class Forgot
{
    public $status;
    private $data;
    private $message;
    private $s_id;
    private $request;
    private $db;
    private $sql;
    private $mailer;
    private $result;
    private $id;
    private $sessionData;

    public function __construct()
    {
        $this->data = array();
        var_dump($this->data);
        $this->status = http_response_code();
        $this->s_id = session_id();
        $this->request = $_SERVER['REQUEST_METHOD'];

        $this->request == 'GET' ? extract($_GET) : extract($_POST);

        //This line of code checck if any empty data is send by client

        if (!isset($_SESSION['authCredentials']) || empty($this->s_id) || $this->s_id == $session_id) {

            $this->data = array();
            $this->message = 'session is empty or expired';
            $this->ResultReturn();

        } else {

            $this->showDashData();

        }

    }


    private function showDashData() {

        $this->db = new Database();
        $this->sessionData = $_SESSION['authCredentials'];
        $this->id = $this->sessionData['userId'];
       // echo $this->id;
        $this->sql = "SELECT resumeNo from  resume where userId = $this->id";
        $this->db->query($this->sql);
        if ($this->db->sql_query->rowCount() > 0) {
            $this->result = $this->db->sql_query->fetchAll(PDO::FETCH_ASSOC);
           
            $this->getPersonalData();

            $this->message = "data fetched";
        } else {

            $this->data = array();
            $this->message = "userId not exist";

        }
        $this->ResultReturn();
        $this->db->close_connection();

    }

    private function getPersonalData(){

            // while($this->result){
            //     echo "resume no = ".$this->result['resumeNo'];
            // }

            
            for ($i=0; $i < count($this->result); $i++) { 
               
                    $resumeNo = $this->result[$i]['resumeNo'];
                    $this->sql = "SELECT id,name,email from PersonalDetails where resumeNo = $resumeNo ";
                    $this->db->query($this->sql);
                    if($this->db->sql_query->rowCount() > 0){
                        $this->data.push($this->data,$this->db->sql_query->fetchAll(PDO::FETCH_ASSOC));
                        
                    }                    
                    

            }

    }




    private function ResultReturn()
    {
        $this->result = array(
            "status" => $this->status,
            "data" => $this->data,
            "message" => $this->message
        );
        echo json_encode($this->result);
    }



};


$newforgot = new Forgot();

?>
