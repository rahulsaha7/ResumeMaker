<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Mpdf\Mpdf;

//Expected format


/*

 $jsonObj =  '{

            "templateData": {

                "personal":{
                    "title":[
                        "name":"Rahul Saha",
                        "email":"forrahul7@gmail.com",
                        "image":"text/image",
                        "phone":"9679165255",
                        "summery":"web developer"
                    ]
                },
            }   
          }';



*/



class generate
{
    public $status;
    private $success;
    private $message;
    private $request;
    private $db;
    private $sql;
    private $values;
    private $result;
    private $id;
    private $t_id;
    private $resumeNo;
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


                //If token is there then verify first then use it

                $decode = JWT::decode($bearerToken, new Key('bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew', 'HS256'));
                $this->id = $decode->userId;
                //echo $templateData;
                $templateData = file_get_contents('php://input');
                // var_dump($templateData);
                $this->data = json_decode($templateData, true);


                $this->storeData();
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


    private function storeData()
    {
        $this->db = new Database();
        $edu = "";
        $personal = "";
        $exp = "";
        $projects = "";
        $skills = "";
        $hobbie = "";
        $lan = "";
        $custom = "";
        foreach ($this->data as $value) {
            $edu = $value['education'];
            $personal = $value['profile'];
            $exp = $value['experience'];
            $projects = $value['projects'];
            $skills = $value['skills'];
            $lan = $value['languages'];
            $hobbie = $value['hobbies'];
            $custom = $value['custom'];

            $this->t_id = $value['templateid'];
        }
        $p = $this->updateResumeTable();
        $this->getPersonalData($personal, $p);
        $this->getEducationalData($edu, $p);
        $this->getExperienceData($exp, $p);
        $this->getProjectsData($projects, $p);
        $this->getSkillsData($skills, $p);
        $this->getLanguageseData($lan, $p);
        $this->getHobbiesData($hobbie, $p);
        $this->getCustomData($custom, $p);
        //After this a pdf file generattor function will be called with all the values

        $this->generateResume();
    }


    private function updateResumeTable()
    {

        $this->resumeNo = rand(10, 100000000);
        $sql = "INSERT into resume (userID,resumeNo) value ($this->id,$this->resumeNo)";
        $this->db->query($sql);
        if ($this->db->sql_query->rowCount() > 0) {
            return 1;
        }
    }

    private function getPersonalData($personal, $p)
    {


        if ($p) {

            foreach ($personal as $value) {
                $sql = "INSERT into PersonalDetails (resumeNo,name,email,image,phone,PSummery) values(?,?,?,?,?,?)";
                $this->values = array($this->resumeNo, $value['name'], $value['email'], $value['image'], $value['phone'], $value['summary']);
                $this->db->query_value($sql, $this->values);
                if ($this->db->sql_query->rowCount() <= 0) {
                    break;
                }
            }
        } else {
            //update details with resumeNo
        }
    }

    private function getEducationalData($edu, $p)
    {


        if ($p) {

            foreach ($edu as $value) {



                $sql = "INSERT into EducationDetails (resumeNo,i_name,d_title,s_year,e_year,present,cgpa,e_summery) values(?,?,?,?,?,?,?,?)";
                $this->values = array($this->resumeNo, $value['instituteName'], $value['degreeTitle'], $value['startYear'], $value['endYear'], $value['tillPresent'], $value['cgpa'], $value['summary']);
                $this->db->query_value($sql, $this->values);
                if ($this->db->sql_query->rowCount() <= 0) {
                    break;
                }
            }
        } else {

            //if non-negative then update existing data
        }
    }

    private function getExperienceData($exp, $p)
    {
        if ($p) {

            foreach ($exp as $value) {
                $sql = "INSERT into Experience (resumeNo,c_name,j_title,s_year,e_year,present,responsibility) values(?,?,?,?,?,?,?)";
                $this->values = array($this->resumeNo, $value['companyName'], $value['jobTitle'], $value['startDate'], $value['endDate'], $value['tillPresent'], $value['summary']);
                $this->db->query_value($sql, $this->values);
                if ($this->db->sql_query->rowCount() <= 0) {
                    break;
                }
            }
        } else {
        }
    }

    private function getProjectsData($projects, $p)
    {

        if ($p) {
            foreach ($projects as $value) {
                $sql = "INSERT into Projects (resumeNo,p_name,p_title,s_year,e_year,present,pr_summery) values(?,?,?,?,?,?,?)";
                $this->values = array($this->resumeNo, $value['projectName'], $value['projectDescription'], $value['startDate'], $value['endDate'], $value['tillPresent'], $value['summary']);
                $this->db->query_value($sql, $this->values);
                if ($this->db->sql_query->rowCount() <= 0) {
                    break;
                }
            }
        } else {
        }
    }

    private function getSkillsData($skills, $p)
    {


        if ($p) {

            foreach ($skills as $value) {
                $sql = "INSERT into Skills (resumeNo,s_name,s_level) values(?,?,?)";
                $this->values = array($this->resumeNo, $value['skillName'], $value['skillLevel']);
                $this->db->query_value($sql, $this->values);
                if ($this->db->sql_query->rowCount() <= 0) {
                    break;
                }
            }
        } else {
        }
    }

    private function getLanguageseData($lan, $p)
    {

        //Sa me as educational data
        if ($p) {

            foreach ($lan as $value) {
                $sql = "INSERT into Languages (resumeNo,l_name,l_level) values(?,?,?)";
                $this->values = array($this->resumeNo, $value['languageName'], $value['languageLevel']);
                $this->db->query_value($sql, $this->values);
                if ($this->db->sql_query->rowCount() <= 0) {
                    break;
                }
            }
        } else {
        }
    }

    private function getHobbiesData($hobbie, $p)
    {


        if ($p) {

            foreach ($hobbie as $value) {
                $sql = "INSERT into Hobby (resumeNo,h_name) values(?,?)";
                $this->values = array($this->resumeNo, $value['hobbyName']);
                $this->db->query_value($sql, $this->values);
                if ($this->db->sql_query->rowCount() <= 0) {
                    break;
                }
            }
        } else {
        }
    }

    private function getCustomData($custom, $p)
    {


        if ($p) {

            foreach ($custom as $value) {
                $sql = "INSERT into custom (resumeNo,description,title,sub_title) values(?,?,?,?)";
                $this->values = array($this->resumeNo, $value['description'], $value['title'], $value['sub_title']);
                $this->db->query_value($sql, $this->values);
                if ($this->db->sql_query->rowCount() <= 0) {
                    break;
                }
            }
        } else {
        }
    }



    private function generateResume()
    {



        $sql = "INSERT into template (resumeNo,t_id) values($this->resumeNo,$this->t_id)";

        //insert name aslo as only by that name I can include file
        $this->db->query($sql);
        if ($this->db->sql_query->rowCount() > 0) {
            $sql = "SELECT * from resume r,PersonalDetails p,EducationDetails e,Experience ep, Skills s where r.resumeNo = p.resumeNo and r.resumeNo = e.resumeNo and r.resumeNo = ep.resumeNo  and r.resumeNo = s.resumeNo and r.resumeNo = $this->resumeNo";
            // echo $sql;
            $this->db->query($sql);
            if ($this->db->sql_query->rowCount() > 0) {
                $resumes = $this->db->sql_query->fetchAll(PDO::FETCH_ASSOC);
                $name = $resumes[0]['name'];
                $email = $resumes[0]['email'];
                $summery = $resumes[0]['PSummery'];
                ob_start();
                readfile('./uploads/template5.php');
                $body = ob_get_clean();
                //echo $body;
                $body = mb_convert_encoding($body, 'UTF-8', 'UTF-8');
                require_once  './vendor/autoload.php';
                $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'tempDir' =>  './mPdfFiles']);
                $mpdf->WriteHTML($body);
                $mpdf->SetWatermarkText('EasyResume');
                $mpdf->showWatermarkText = true;
                $mpdf->watermarkTextAlpha = 0.1;
                // $filename = "EasyResume" . rand(1000000, 99999999) . ".pdf";
                $mpdf->Output();
            }
        } else {
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


$newforgot = new generate();
