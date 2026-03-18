<?php
namespace App\Сontrollers;

use PDOException;
use PDO;

require_once '../../connection/connect.php';

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
                    http_response_code(200);
                    header("Location: ../../profile.php");
                } else {
                return "Неверный логин или пароль";
                }
            } else {
                return "Неверный логин или пароль";
            }
        }
        catch(PDOException $e){
            http_response_code(400);
            die('Ошибка запроса');
        } 
    }
}

$login = new LoginController($_POST['email'], $_POST['password'], $pdo);
$login->authUser();