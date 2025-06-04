<?php
$host = 'srv1549.hstgr.io';
$db = 'u210018739_crud_php';
$user = 'u210018739_isaac';
$password = '12345678Is$';
try {
    $pdo = new PDO("mysql:host=$host; dbname=$db; charset=utf8", $user, $password);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    exit;
}
?>
