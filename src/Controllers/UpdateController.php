<?php
namespace App\Controllers;

use PDOException;
use PDO;

require_once '../../connection/connect.php';

class UpdateController{
    private $name = '';
    private $password = '';
    private $email = '';
    private $phone = '';
    private $pdo;

    public function __construct($name, $password1, $password2, $email, $phone, $pdo)
    {
        if (!empty($name) || !empty($email) || !empty($phone) || (!empty($password1) && !empty($password2))){
            if ($password1 !== $password2){
                http_response_code(400);
                die('Пароли не совпадают!');
            }
            $this->name = empty($name) ? $_SESSION['name'] : $name;
            $this->password = empty($password1) ? $_SESSION['password'] : password_hash($password1, PASSWORD_DEFAULT);
            $this->email = empty($email) ? $_SESSION['email'] : $email;
            $this->phone = $phone;
            $this->pdo = $pdo;
        }
        else{
            http_response_code(400);
            die('Заполните все поля');
        }
    }

    public function updateUser()
    {
        $sql = "UPDATE users SET name = :name, email = :email, password = :password, phone = :phone WHERE email = :email;"; 
        try{
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['name' => $this->name, 'password' => $this->password, 'email' => $this->email, 'phone' => $this->phone]);
        }
        catch(PDOException $e){
            http_response_code(400);
            die('Ошибка запроса');
        } 
    }
}