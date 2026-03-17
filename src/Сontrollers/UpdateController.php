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

    public function __construct($name, $email, $phone, $pdo)
    {
        if (!empty($name) && !empty($email) && !empty($phone)){
            $this->name = !empty($name) ? $name : $_SESSION['name'];
            $this->email = !empty($email) ? $email : $_SESSION['email'];
            $this->phone = !empty($phone) ? $phone : $_SESSION['phone'];
            $this->pdo = $pdo;
        }
        else{
            http_response_code(400);
            die('Заполните минимум 1 поле');
        }
    }

    public function updateUser()
    {
        $sql = "UPDATE users SET name = :name, email = :email, phone = :phone WHERE email = :email;"; 
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