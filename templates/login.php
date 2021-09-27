<?php
    
    $status = 0;
    $data = false;
    $message = " ";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $status = 1;
        

        extract($_POST);
        $email = cleanData($email);
        
        $db = new database();

        $values = array($email);

         $sql = "SELECT id,email,password from auth where email = ?";

         $db->query_value($sql,$values);

         if($db->sql_query->rowCount() > 0){

                $result = $db->sql_query->fetchAll(PDO::FETCH_ASSOC);
                
               if(password_verify($password,$result[0]['password'])){
                   $data = true;
                   $message = "Login Successfull";
               }else{
                $data = false;
                $message = "Password Missmatched";
               }
                
         }
         else{
            $data = false;
            $message = "username doesn't exixst";
         }
        

    

    }else{
        $status = 2;
        
        $message = "Something went Wrong";
    }
    $result = array(
        "status"=>$status,
        "data"=>$data,
        "message"=>$message
    );
    echo json_encode($result);
    $db->close_connection();

    function cleanData($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

?>