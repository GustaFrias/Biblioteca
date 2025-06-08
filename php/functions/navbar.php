<?php
require 'conexao.php';
if(isset($_GET['busca'])){
    $busca= "%". $_GET['busca'] ."%";
    $sql= "SELECT* FROM livros where titulo LIKE :busca";
    $stmt= $pdo->prepare($sql);
    $stmt->bindParam(':busca' ,$busca, PDO::PARAM_STR);
    $stmt->execute();

       if ($stmt->rowCount() > 0) { 
        echo "<h2>Resultados da busca:</h2>";
        while ($livro = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<p><strong>Título:</strong> " . htmlspecialchars($livro['titulo']) . "<br>";
            echo "<strong>Autor:</strong> " . htmlspecialchars($livro['autor']) . "</p>";
        }
    } else {
        echo "Nenhum livro encontrado para '" . htmlspecialchars($_GET['busca']) . "'.";
    }
} else {
    echo "Por favor, insira um termo para busca.";
}
