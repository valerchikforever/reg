<?php
namespace App\Controllers;

use PDOException;
use PDO;

class LoginController{
    private $password;
    private $email_phone;
    private $pos;
    private $pdo;

    public function __construct($email_phone, $password, $pdo)
    {
        if (!empty($email_phone) && !empty($password)){
            $this->email_phone = $email_phone;
            $this->password = $password;
            $this->pdo = $pdo;
        }
        else{
            http_response_code(400);
            die('Заполните все поля');
        }
    }

    public function authUser()
    {
        if (strpos($this->email_phone, "@")){
            $sql = "SELECT * FROM users WHERE email = :email";
            $index = 'email';
        }
        else{
            $sql = "SELECT * FROM users WHERE phone = :phone"; 
            $index = 'phone';
        }
        try{
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$index => $this->email_phone]);

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($this->password, $row['password'])) {
                    session_start();
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['phone'] = $row['phone'];
                    $_SESSION['password'] = $row['password'];
                    http_response_code(200);
                    header("Location: ../../profile.php");
                } else {
                    die("Неверный логин или пароль");
                }
            } else {
                die("Неверный логин или пароль");;
            }
        }
        catch(PDOException $e){
            http_response_code(400);
            die('Ошибка запроса');
        } 
    }
}