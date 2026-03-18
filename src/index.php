<?php
session_start();
header('Content-type: application/json'); //возвращать всё в JSON
require_once "../connection/connect.php";     //подключение к БД

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\RegistrationController;
use App\Controllers\LoginController;
use App\Controllers\UpdateController;

$method = $_SERVER["REQUEST_METHOD"]; //получение метода
$q = $_GET['q']; //строка после http://api/ (tasks/1)
$params = explode('/', $q);

$type = $params[0];
$id = isset($params[1]) ? $params[1] : null;

$is_logged = isset($_SESSION['id']);

switch ($method){
    case "POST":
        if ($type === "register"){
            $register = new RegistrationController($_POST['name'], $_POST['password1'], $_POST['password2'], $_POST['email'], $_POST['phone'], $pdo);
            $register->addUser();
        }
        elseif($type === "login"){
            $login = new LoginController($_POST['email'], $_POST['password'], $pdo);
            $login->authUser();
        }
        elseif($is_logged && $type == "update"){
            $data = file_get_contents('php://input');
            $update = new UpdateController($_POST['name'], $_POST['password1'], $_POST['password2'], $_POST['email'], $_POST['phone'], $pdo);
            $update->updateUser();
        }
        else{
            http_response_code(502);
            $result = [ 
                'status' => false,
                'message' => 'Bad Gateway (Ошибочный шлюз)'
            ];
            exit(json_encode($result));
        }
        break;
    case "DELETE":
        if($is_logged && $id && $type == "delete"){
            deletePost($pdo, $id);  //Удаление задачи по id
        }
        break;
    default:               //При любом другом методе выдаст ошибку
        http_response_code(405);
        $result = [
            'status' => false,
            'message' => 'Method Not Allowed (Метод не поддерживается)'
        ];
        
        echo json_encode($result);
        break;
}
?>