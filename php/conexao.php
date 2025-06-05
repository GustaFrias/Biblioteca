<?php
$host = 'srv1549.hstgr.io';
$db = 'biblioteca';
$user = 'u210018739_isaac';
$password = '12345678Is$';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
} catch (PDOException $e) {
    exit("Erro na conexão com o banco de dados.");
}