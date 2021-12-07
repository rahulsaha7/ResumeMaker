<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


//Expected format


/*

 $jsonObj =  '{

            "templateData": {

                "personal":{
                    "title":[
                        "name",
                        "email",
                        "image",
                        "phone",
                        "PSummery"
                    ]
                },
                "education":{

                    "title":[

                        "i_name",
                        "d_title",
                        "s_year",
                        "e_year",
                        "present",
                        "cpga",
                        "e_summery"
                     
                    ],
                    "title2":[
                         "i_name",
                        "d_title",
                        "s_year",
                        "e_year",
                        "present",
                        "cpga",
                        "e_summery"
                    ]
                },
                "projects":{
                    "title":[
                        "p_name",
                        "p_title",
                        "s_year",
                        "e_year",
                        "present",
                        "pr_summery"
                        ]
                },
                    "experience":{
                        "title":[
                            "c_name",
                            "j_title",
                            "s_year",
                            "e_year",
                            "present",
                            "responsibility"
                        ],
                        "title2":[
                           "c_name",
                            "j_title",
                            "s_year",
                            "e_year",
                            "present",
                            "responsibility"
                        ]
                    },
                    "skills":{
                        "title":[
                            "s_name",
                            "s_level"
                        ]
                    },
                    "languages":{
                        "title":[
                            "l_name",
                            "l_level"
                        ]
                    },
                    "hobby":{
                        "title":[
                            "h_name"
                        ]
                    }
                
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

                if (isset($resumeno)) {
                    $this->resumeNo = $resumeno;
                }


                //If token is there then verify first then use it

                $decode = JWT::decode($bearerToken, new Key('bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew', 'HS256'));
                $this->id = $decode->userId;

                $this->storeData($templateData, $templateId);
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


    private function storeData($templateData, $templateId)
    {

        $this->data = json_decode($templateData, true);
        $this->t_id = $templateData;
        $this->db = new Database();
        $edu = "";
        $personal = "";
        $exp = "";
        $projects = "";
        $skills = "";
        $hobbie = "";
        $lan = "";
        foreach ($this->data as $value) {
            $edu = $value['education'];
            $personal = $value['personal'];
            $exp = $value['experience'];
            $projects = $value['projects'];
            $skills = $value['skills'];
            $lan = $value['languages'];
            $hobbie = $value['hobby'];
        }
        $p = $this->updateResumeTable();
        $this->getPersonalData($personal, $p);
        $this->getEducationalData($edu, $p);
        $this->getExperienceData($exp, $p);
        $this->getProjectsData($projects, $p);
        $this->getSkillsData($skills, $p);
        $this->getLanguageseData($lan, $p);
        $this->getHobbiesData($hobbie, $p);

        //After this a pdf file generattor function will be called with all the values

    }


    private function updateResumeTable()
    {
        if (empty($this->resumeNo)) {
            $this->resumeNo = rand(10, 100000000);
            $sql = "INSERT into resume (userID,resumeNo) value ($this->id,$this->resumeNo)";
            $this->db->query($sql);
            if ($this->db->sql_query->rowCount() > 0) {
                return 1;
            }
        } else {
            return -1;
        }
    }

    private function getPersonalData($personal, $p)
    {

        //Update personal data if resume no exist on  resume table;
        //If not exist then insert the data
        if ($p) {
            //Insert new details with resumeNo 
            foreach ($personal as $value) {
                $sql = "INSERT into PersonalDetails (resumeNo,name,email,image,phone,PSummery) values(?,?,?,?,?,?)";
                $this->values = array($this->resumeNo, $value[0], $value[1], $value[2], $value[3], $value[4]);
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

        //if $p is 1 that means true and that means insert new data to table
        if ($p) {

            foreach ($edu as $value) {
                $sql = "INSERT into EducationDetails (resumeNo,i_name,d_title,s_year,e_year,present,cgpa,e_summery) values(?,?,?,?,?,?,?,?)";
                $this->values = array($this->resumeNo, $value[0], $value[1], $value[2], $value[3], $value[4], $value[5], $value[6]);
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
                $this->values = array($this->resumeNo, $value[0], $value[1], $value[2], $value[3], $value[4], $value[5]);
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
                $this->values = array($this->resumeNo, $value[0], $value[1], $value[2], $value[3], $value[4], $value[5]);
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
                $this->values = array($this->resumeNo, $value[0], $value[1], $value[2]);
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
                $this->values = array($this->resumeNo, $value[0], $value[1], $value[2]);
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
                $sql = "INSERT into Hobby (resumeNo,h_name) values(?,?,?)";
                $this->values = array($this->resumeNo, $value[0], $value[1]);
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
                $sql = "INSERT into Experience (resumeNo,c_name,j_title,s_year,e_year,present,responsibility) values(?,?,?,?,?,?,?)";
                $this->values = array($this->resumeNo, $value[0], $value[1], $value[2], $value[3], $value[4], $value[5]);
                $this->db->query_value($sql, $this->values);
                if ($this->db->sql_query->rowCount() <= 0) {
                    break;
                }
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
