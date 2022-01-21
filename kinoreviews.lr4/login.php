<?php
header('Content-Type: application/json');
//сообщаем браузеру, что ответ будет в формате JSON
require 'db.php';

$errors = [];

//логика проверки полей

$email = $_POST['email'];
$password = $_POST['password'];

$email = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, 'UTF-8');
$password = htmlspecialchars($password, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, 'UTF-8');


$email_check = $connection->prepare("SELECT * FROM users WHERE email=?");
$email_check->execute([$email]);
$email_check = $email_check->fetchAll();

if (count($email_check) != 1) {
    array_push($errors, "email");
    echo json_encode(['errors' => $errors]);
    die();
}

$password_hash = $email_check[0]['password'];
if (!(password_verify($password, $password_hash))) {
    array_push($errors, "password");
    echo json_encode(['errors' => $errors]);
    die();
}

session_start();
$_SESSION['user'] = [
    'id' => $email_check[0]['id'],
    'name' => $email_check[0]['name'],
];

echo json_encode(['success' => true]);
