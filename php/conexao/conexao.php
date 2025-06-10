<?php
$host = 'localhost';
$db = 'livraria';
$user = 'root';
$password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
} catch (PDOException $e) {
    exit("Erro na conexão com o banco de dados.");
}