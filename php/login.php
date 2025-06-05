<?php
session_start();
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $entrada = $_POST['email'];
    $senha = $_POST['senha'];


    $sqlAdm = "SELECT * FROM usuarios_adm WHERE nome = :nome AND senha = :senha";
    $stmtAdm = $pdo->prepare($sqlAdm);
    $stmtAdm->bindParam(':nome', $entrada);
    $stmtAdm->bindParam(':senha', $senha);
    $stmtAdm->execute();

    if ($stmtAdm->rowCount() > 0) {
        $_SESSION['admin'] = true;
        $_SESSION['nome'] = $entrada;
        header("Location: ../php/admin.php");
        exit;
    }


    $sqlUser = "SELECT * FROM clientes WHERE email = :email AND senha = :senha";
    $stmtUser = $pdo->prepare($sqlUser);
    $stmtUser->bindParam(':email', $entrada);
    $stmtUser->bindParam(':senha', $senha);
    $stmtUser->execute();

    if ($stmtUser->rowCount() > 0) {
        $usuario = $stmtUser->fetch();
        $_SESSION['usuario'] = $usuario['nome'];
        $_SESSION['usuario_id'] = $usuario['id'];
        header("Location: area_usuario.php");
        exit;
    }


    header("Location: ../htmls/login.html");
    exit;
}
?>
