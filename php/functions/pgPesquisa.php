<?php
require '../conexao/conexao.php';

if (isset($_GET['busca'])) {
    $busca = "%" . $_GET['busca'] . "%";
    $sql = "SELECT livros.*, autores.nome AS nome_autor 
            FROM livros 
            LEFT JOIN autores ON livros.autor_id = autores.id 
            WHERE livros.titulo LIKE :busca";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':busca', $busca, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        while ($livro = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='card'>";
            echo "<a href='/Biblioteca-main/htmls/moreInfo.php?id=" . htmlspecialchars($livro['id']) . "'>";
            echo "<img src='../uploads/" . htmlspecialchars($livro['imagem']) . "' class='capaLivros' width='100'><br>";
            echo htmlspecialchars($livro['titulo']) . "</a><br>";
           echo "Autor: " . htmlspecialchars($livro['nome_autor']);
            echo "</div>";
        }
    } else {
        echo "<p>Nenhum livro encontrado.</p>";
    }
}
?>