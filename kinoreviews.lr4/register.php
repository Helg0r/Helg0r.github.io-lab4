<?php
header('Content-Type: application/json');
//сообщаем браузеру, что ответ будет в формате JSON
require 'db.php';

$errors = [];

//логика проверки полей

$name_pattern = '/[А-Яа-я\s-]*/';
$email_pattern = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/';
$phone_pattern = '/8\d{3}\d{3}\d{2}\d{2}/';
$password_pattern = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,40}$/';

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$passwordRepeat = $_POST['passwordRepeat'];
$checkbox = $_POST['checkbox'];

$name = htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, 'UTF-8');
$email = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, 'UTF-8');
$phone = htmlspecialchars($phone, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, 'UTF-8');
$password = htmlspecialchars($password, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, 'UTF-8');
$passwordRepeat = htmlspecialchars($passwordRepeat, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, 'UTF-8');

// echo($phone . $password . $passwordRepeat);

if (!preg_match($name_pattern, $name)) {
    array_push($errors, "name");
}
if (!preg_match($email_pattern, $email)) {
    array_push($errors, "email");
}
if (!preg_match($phone_pattern, $phone)) {
    array_push($errors, "phone");
}
if (!preg_match($password_pattern, $password)) {
    array_push($errors, "password");
}
if ($passwordRepeat != $password) {
    array_push($errors, "passwordRepeat");
}
if ($checkbox != "on") {
    array_push($errors, "checkbox");
}


if (!empty($errors)) {
    echo json_encode(['errors' => $errors]);
    die();
}

$password = password_hash($password, PASSWORD_DEFAULT);

$email_check = $connection->prepare("SELECT * FROM users WHERE email=?");
$email_check->execute([$email]);
$email_check = $email_check->fetchAll();

if (count($email_check) != 0) {
    echo json_encode(['email_check' => false]);
    die();
}

$status = $connection->prepare("INSERT INTO users (email, password, name, phone_number) VALUES (?, ?, ?, ?)");
$status->execute([$email, $password, $name, $phone]);

$email_check = $connection->prepare("SELECT * FROM users WHERE email=?");
$email_check->execute([$email]);
$email_check = $email_check->fetchAll();

session_start();
$_SESSION['user'] = [
    'id' => $email_check[0]['id'],
    'name' => $email_check[0]['name'],
];

echo json_encode(['email_check' => true, 'success' => true]);
