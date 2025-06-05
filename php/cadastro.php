<?php

require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];


    if ($senha !== $confirma_senha) {
        header("Location: index.html?erro=senhas_diferentes");
        exit;
    }


    $sqlCheck = "SELECT id FROM Clientes WHERE email = :email";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->bindParam(':email', $email);
    $stmtCheck->execute();

    if ($stmtCheck->rowCount() > 0) {
        header("Location: index.html?erro=email_existe");
        echo("email ja existe");
        exit;
    }


    $data_cadastro = date('Y-m-d H:i:s');


    $sql = "INSERT INTO Clientes (nome, email, senha, data_cadastro) VALUES (:nome, :email, :senha, :data_cadastro)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':data_cadastro', $data_cadastro);

    if ($stmt->execute()) {
        header("Location: ../htmls/login.html?cadastro=sucesso");
        exit;

    } else {
 
        header("Location: ../htmls/index.html?erro=erro_banco");
        exit;
    }
} else {

    header("Location: ../htmls/index.html");
    exit;
}
?>

