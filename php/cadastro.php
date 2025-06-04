<?php
require 'conexao.php';
 if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha']; 
    $data_cadastro = date('Y-m-d H:i:S');

    $sql= "INSERT INTO Clientes(nome, email, senha, data_cadastro) VALUES(:nome, :email, :senha, :data_cadastro)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':data_cadastro', $data_cadastro);

    if ($stmt->execute()) {
        header("Location: login.html?cadastro=1");
        exit;
    } else {
        header("Location: login.php?erro=2");
        exit;
    }
}
?>  
