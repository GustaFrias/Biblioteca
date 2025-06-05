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
<a href="">Cadastrar novo filme</a> | <a href="">Sair</a>
<hr>

<?php foreach ($livros as $livro): ?>
    <div>
        <h3><?php echo htmlspecialchars($livro['nome']); ?></h3>
        <p><strong>Gênero:</strong> <?php echo htmlspecialchars($livro['genero']); ?></p>
        <p><strong>Ano:</strong> <?php echo htmlspecialchars($livro['ano']); ?></p>
        <p><strong>Sinopse:</strong> <?php echo htmlspecialchars($livro['sinopse']); ?></p>
        <img src="<?php echo htmlspecialchars($livro['imagem']); ?>" alt="Imagem do filme" width="200">
        
        <!-- Links para editar e deletar -->
        <br><br>
        <a href="edit.php?id=<?php echo $livro['id']; ?>">Editar</a> |
        <a href="delete.php?id=<?php echo $livro['id']; ?>" onclick="return confirmarExclusao();">Deletar</a>
    </div>
    <hr>
<?php endforeach; ?>

</body>
</html>
