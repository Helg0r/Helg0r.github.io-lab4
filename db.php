<?php
$config_data = parse_ini_file("config/parameters.ini");
$login = $config_data['login'];
$password = $config_data['password'];
$host = $config_data['host'];
$db_name = $config_data['name'];
try {
    $connection = new PDO("mysql:host=" . $host . ";dbname=" . $db_name . ";charset=utf8", $login, $password);
} catch (PDOException $e) {
    echo "Ошибка подключения к БД: " . $e->getMessage();
    die();
}
