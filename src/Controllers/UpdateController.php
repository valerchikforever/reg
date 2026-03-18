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
    private $pdo;

    public function __construct($name, $newemail, $phone, $pdo, $oldemail)
    {
        if (!empty($name) || !empty($newemail) || !empty($phone)){
            $this->name = empty($name) ? $_SESSION['name'] : $name;
            $this->newemail = empty($newemail) ? $oldemail : $newemail;
            $this->oldemail = $oldemail;
            $this->phone = empty($phone) ? $_SESSION['phone'] : $phone;
            $this->pdo = $pdo;

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
        else{
            http_response_code(400);
            die('Заполните хотя бы 1 поле');
        }
    }

    public function updateUser()
    {
        $sql = "UPDATE users SET name = :name, email = :newemail, phone = :phone WHERE email = :oldemail;"; 
        try{
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['oldemail' => $this->oldemail, 'name' => $this->name, 'newemail' => $this->newemail, 'phone' => $this->phone]);
            $_SESSION['name'] = $this->name;
            $_SESSION['email'] = $this->newemail;
            $_SESSION['phone'] = $this->phone;

            header("Location: ../../profile.php");
            exit(); 

        }
        catch(PDOException $e){
            http_response_code(400);
            die('Ошибка запроса');
        } 
    }
}