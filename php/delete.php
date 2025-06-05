<?php
require 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM livros WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: ../php/admin.php");
    } else {
        echo "Erro ao excluir o livro.";
    }
} else {
    echo "ID não especificado.";
}
?>
