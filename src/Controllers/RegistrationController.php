<?php
namespace App\Controllers;

use PDOException;
use PDO;

class RegistrationController{
    private $name;
    private $password;
    private $email;
    private $phone;
    private $pdo;

    public function __construct($name, $password1, $password2, $email, $phone, $pdo)
    {
        if (!empty($name) && !empty($email) && !empty($phone) && !empty($password1) && !empty($password2)){
            if ($password1 !== $password2){
                http_response_code(400);
                die('Пароли не совпадают!');
            }
            $this->name = $name;
            $this->password = password_hash($password1, PASSWORD_DEFAULT);
            $this->email = $email;
            $this->phone = $phone;
            $this->pdo = $pdo;
        }
        else{
            http_response_code(400);
            die('Заполните все поля');
        }
    }

    public function addUser()
    {
        $sql = "SELECT * FROM users WHERE email = :email OR name = :name OR phone = :phone"; 
        try{
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['name' => $this->name, 'email' => $this->email, 'phone' => $this->phone]);

            if (!empty($stmt->fetch(PDO::FETCH_ASSOC))){
                die('Пользователь c таким логином, номером телефона или почтой уже существует');
            }
        }
        catch(PDOException $e){
            http_response_code(400);
            die('Ошибка запроса');
        } 

        $sql = "INSERT INTO users (name, password, email, phone) VALUES (:name, :password, :email, :phone)"; 
        try{
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['name' => $this->name, 'password' => $this->password, 'email' => $this->email, 'phone' => $this->phone]);
            session_start();
            $_SESSION['id'] = $this->pdo->lastInsertId();
            $_SESSION['name'] = $this->name;
            $_SESSION['email'] = $this->email;
            $_SESSION['phone'] = $this->phone;
            $_SESSION['password'] = $this->password;
            http_response_code(200);
            header('Location: ../../profile.php');
        }
        catch(PDOException $e){
            http_response_code(400);
            die('Ошибка регистрации');
        }    
    }
}