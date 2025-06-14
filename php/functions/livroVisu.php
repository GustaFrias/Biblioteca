<?php
require '../conexao/conexao.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];
    $sql = "SELECT livros.*, autores.nome AS nome_autor 
            FROM livros 
            LEFT JOIN autores ON livros.autor_id = autores.id 
            WHERE livros.id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $livro = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<h2>" . htmlspecialchars($livro['titulo']) . "</h2>";
        echo "<p>Autor: " . htmlspecialchars($livro['nome_autor']) . "</p>";
        echo "<img src='../uploads/" . htmlspecialchars($livro['imagem']) . "' width='200'><br>";
        echo "<p>" . nl2br(htmlspecialchars($livro['descricao'])) . "</p>";
    } else {
        echo "Livro não encontrado.";
    }
} else {
    echo "ID não informado ou inválido.";
}
?>