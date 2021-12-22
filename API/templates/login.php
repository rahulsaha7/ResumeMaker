<?php



use Firebase\JWT\JWT;


class login
{
    public $status;
    private $login;
    private $message;
    private $request;
    private $db;
    private $sql;
    private $values;
    private $result;
    private $payload;
    private $secretCode;
    private $jwt;
    private $issuedAt;
    private $expire;

    public function __construct()
    {


        $this->status = http_response_code();
        $this->request = $_SERVER['REQUEST_METHOD'];
        $this->request == 'GET' ? extract($_GET) : extract($_POST);

        //This line of code checck if any empty data is send by client



        if (!isset($password) || !isset($email) || empty($password) || empty($email)) {

            $this->login = false;
            if (!isset($password) || empty($password)) {

                $this->message = "password field should not be empty";
            } else {

                $this->message = "email field should not be empty";
            }

            $this->Returnresult();
        } else {
            $email = $this->cleanData($email);
            $this->Login($email, $password);
        }
    }

    public function cleanData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    private function Login($email, $password)
    {
        $this->values = array($email);
        $this->sql = "SELECT userID,name,email,password from auth where email = ?";
        $this->db = new database();
        $this->db->query_value($this->sql, $this->values);

        if ($this->db->sql_query->rowCount() > 0) {

            $this->result = $this->db->sql_query->fetchAll(PDO::FETCH_ASSOC);
            if (password_verify($password, $this->result[0]['password'])) {
                $this->login = true;
                $this->message = "Login Successfull";

                // $_SESSION['authCredentials'] = $this->sessionData;
                $this->secretCode = "bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew";
                $this->issuedAt   = new DateTimeImmutable();
                $this->expire     = $this->issuedAt->modify('+3600 minutes')->getTimestamp();
                $this->payload = array(
                    'iat'  => $this->issuedAt->getTimestamp(),         // Issued at: time when the token was generated
                    'nbf'  => $this->issuedAt->getTimestamp(),
                    'exp'  => $this->expire,
                    'userId' => $this->result[0]['userID'],
                    'name' => $this->result[0]['name'],
                    'username' => $this->result[0]['email'],
                    'url' => 'https://www.maldanattyasena.com'

                );
                $this->jwt = JWT::encode($this->payload, $this->secretCode, 'HS256');
            } else {
                $this->login = false;
                $this->message = "Password Missmatched";
            }
        } else {
            $this->login = false;
            $this->message = "username doesn't exixst";
        }

        $this->Returnresult();

        $this->db->close_connection();
    }

    private function Returnresult()
    {

        $this->result = array(
            "status" => $this->status,
            "login" => $this->login,
            "message" => $this->message,
            "token" => $this->jwt,
        );
        echo json_encode($this->result);
    }
};

$login = new login();
