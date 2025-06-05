<?php
require 'verifica.php';
require 'conexao.php';
$sql = "SELECT * FROM livros";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$livros = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo</title>
    <script>
        function confirmarExclusao() {
            return confirm("Tem certeza de que deseja excluir este livro?");
        }
    </script>
</head>
<body>

<h1>Área Administrativa - Lista de Livros</h1>
<a href="create.php">Cadastrar novo livro</a> | <a href="logout.php">Sair</a>
<hr>

<?php foreach ($livros as $livro): ?>
    <div>
        <h3><?php echo htmlspecialchars($livro['titulo']); ?></h3>
        <p><strong>Autor:</strong> <?php echo htmlspecialchars($livro['autor']); ?></p>
        <p><strong>Preço:</strong> <?php echo htmlspecialchars($livro['preco']); ?></p>
        <p><strong>Em Estoque:</strong> <?php echo htmlspecialchars($livro['estoque']); ?></p>
        
        <br><br>
        <a href="edit.php?id=<?php echo $livro['id']; ?>">Editar</a> |
        <a href="delete.php?id=<?php echo $livro['id']; ?>" onclick="return confirmarExclusao();">Deletar</a>
    </div>
    <hr>
<?php endforeach; ?>

</body>
</html>
