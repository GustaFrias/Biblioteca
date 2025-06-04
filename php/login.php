<?php
session_start();
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"]==="POST"){
    $email= $_POST['email'];
    $senha= $_POST['senha'];

    $sql= "SELECT * from Clientes WHERE email = :email AND senha=:senha";
    $stmt = $pdo->prepare ($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->execute();   

    if($stmt->rowCount()> 0){
        $_SESSION['admin']= true;
        header("location: admin.php");
        exit;
    } else{
        header ("Location:login.html?erro=1");
        exit;
    }
}
?>
