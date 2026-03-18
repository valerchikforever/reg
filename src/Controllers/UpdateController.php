<?php
namespace App\Controllers;
session_start();

use PDOException;
use PDO;

class UpdateController{
    private $name = '';
    private $newemail = '';
    private $oldemail = '';
    private $phone = '';
    private $password = '';
    private $pdo;

    public function __construct($name, $password1, $password2, $newemail, $phone, $pdo, $oldemail)
    {
        if (!empty($name) || !empty($newemail) || !empty($phone) || (!empty($password1) && !empty($password2))){
            if ($password1 !== $password2){
                http_response_code(400);
                die('Пароли не совпадают!');
            }
            
            $this->name = empty($name) ? $_SESSION['name'] : $name;
            $this->newemail = empty($newemail) ? $oldemail : $newemail;
            $this->oldemail = $oldemail;
            $this->password = empty($password1) ? $_SESSION['password'] : password_hash($password1, PASSWORD_DEFAULT);
            $this->phone = empty($phone) ? $_SESSION['phone'] : $phone;
            $this->pdo = $pdo;

            if (!empty($name) || !empty($newemail) || !empty($phone)){
                $sql = "SELECT * FROM users WHERE name = :newname OR email = :newemail OR phone = :newphone"; 
                try{
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute(['newemail' => $this->newemail, 'newphone' => $this->phone, 'newname' => $this->name]);
                    if ($stmt->rowCount() > 0){
                        http_response_code(400);
                        die('Пользователь с такими данными существует!');
                    }
                }
                catch(PDOException $e){
                    http_response_code(400);
                    die('Ошибка запроса');
                } 
            }
        }
        else{
            http_response_code(400);
            die('Заполните минимум 1 поле');
        }
    }

    public function updateUser()
    {
        $sql = "UPDATE users SET name = :name, email = :newemail, password = :password, phone = :phone WHERE email = :oldemail;"; 
        try{
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['oldemail' => $this->oldemail, 'password' => $this->password, 'name' => $this->name, 'newemail' => $this->newemail, 'phone' => $this->phone]);
            $_SESSION['name'] = $this->name;
            $_SESSION['email'] = $this->newemail;
            $_SESSION['phone'] = $this->phone;
            http_response_code(200);
            header("Location: ../../profile.php");
            exit(); 

        }
        catch(PDOException $e){
            http_response_code(400);
            die('Ошибка запроса');
        } 
    }
}