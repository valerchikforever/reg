<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try{
    $pdo = new PDO(
    "mysql:host={$_ENV['DATABASE_HOST']};dbname={$_ENV['DATABASE_NAME']}",
    $_ENV['DATABASE_USER'],
    $_ENV['DATABASE_PASS']
    );
}catch(PDOException $e){
    echo $e->getMessage();
}