<?php
session_start();
header('Content-type: application/json');
require_once "../connection/connect.php";

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\RegistrationController;
use App\Controllers\LoginController;
use App\Controllers\UpdateController;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../connection/');
$dotenv->load();

$error = true;
$secret = $_ENV['CAPTCHA_SECRET_KEY'];
 
if (!empty($_POST['g-recaptcha-response'])) {
	$out = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
	$out = json_decode($out);
	if ($out->success == true) {
		$error = false;
	} 
}
 
if ($error) {
	die('Ошибка заполнения капчи.');
}

$method = $_SERVER["REQUEST_METHOD"];
$q = $_GET['q'];
$params = explode('/', $q);

$type = $params[0];
$id = isset($params[1]) ? $params[1] : null;

$is_logged = isset($_SESSION['email']);

switch ($method){
    case "POST":
        if ($type === "register"){
            $register = new RegistrationController($_POST['name'], $_POST['password1'], $_POST['password2'], $_POST['email'], $_POST['phone'], $pdo);
            $register->addUser();
        }
        elseif($type === "login"){
            $login = new LoginController($_POST['email_phone'], $_POST['password'], $pdo);
            $login->authUser();
        }
        elseif($is_logged && $type == "update"){
            $data = file_get_contents('php://input');
            $update = new UpdateController($_POST['name'], $_POST['password1'], $_POST['password2'], $_POST['email'], $_POST['phone'], $pdo, $_SESSION['email']);
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
    default: 
        http_response_code(405);
        $result = [
            'status' => false,
            'message' => 'Method Not Allowed (Метод не поддерживается)'
        ];
        
        echo json_encode($result);
        break;
}
?>