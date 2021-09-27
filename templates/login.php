<?php
    
  

    if($_SERVER['REQUEST_METHOD'] == 'POST'){


        extract($_POST);
        $email = cleanData($email);
        
        $db = new database();

        $values = array($email);

         $sql = "SELECT id,email,password from auth where email = ?";

         $db->query_value($sql,$values);

         if($db->sql_query->rowCount() > 0){

                $result = $db->sql_query->fetchAll(PDO::FETCH_ASSOC);
                
               if(password_verify($password,$result[0]['password'])){
                   echo "login successfull";
               }else{
                   echo "password Missmatch";
               }
                
         }
         else{
             echo "username doesn't exixst";
         }
        

    

    }else{
        echo "error will be return with cross browser not supporting";
    }
    $db->close_connection();

    function cleanData($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

?>