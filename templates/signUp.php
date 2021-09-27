<?php

//Modify Everything in basis of class 
// now test it using normal functional way but transfer it class componenet later.

//return json data with accurate formatting and with status code for every type like success or error;


//tomorrow create private empty repo and push this login data to remp with proper call formatting


    if($_SERVER['REQUEST_METHOD'] == 'POST'){


        extract($_POST);
        $email = cleanData($email);
        $name = cleanData($name);
        $phone = cleanData($phone);
        $id = strtotime('now');
        $date = date("Y-m-d", strtotime("now"));

        $password = password_hash($password,PASSWORD_BCRYPT);
        
        $db = new database();

        $values = array($id,$name,$email,$phone,$password,$date);

         $sql = "INSERT into auth (id,name,email,phone,password,joinDate) values (?,?,?,?,?,?)";

         $db->query_value($sql,$values);

         if($db->sql_query->rowCount() > 0){

                
                echo "successfull";
                
         }
        
    $db->close_connection();

    }else{
        echo "error will be return with cross browser not supporting";
    }

    function cleanData($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

?>