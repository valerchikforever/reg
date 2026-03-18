<?php
namespace App\Controllers;

use PDOException;
use PDO;

class LoginController{
    private $name;
    private $password;
    private $email;
    private $pdo;

    public function __construct($email, $password, $pdo)
    {
        if (!empty($email) && !empty($password)){
            $this->email = $email;
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
        $sql = "SELECT * FROM users WHERE email = :email"; 
        try{
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['email' => $this->email]);

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