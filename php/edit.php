<?php
require 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM livros WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $livro = $stmt->fetch();

    if (!$livro) {
        echo "Livro não encontrado.";
        exit;
    }
} else {
    echo "ID não especificado.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];

    $sql = "UPDATE livros SET titulo = :titulo, autor = :autor, preco = :preco, estoque = :estoque WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':autor', $autor);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':estoque', $estoque);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Livro atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o livro.";
    }
}
?>

<form method="POST" action="edit.php?id=<?php echo $livro['id']; ?>" enctype="multipart/form-data">
    <label>Título do livro:</label><br>
    <input type="text" name="titulo" value="<?php echo htmlspecialchars($livro['titulo']); ?>" required><br><br>

    <label>Autor:</label><br>
    <input type="text" name="autor" value="<?php echo htmlspecialchars($livro['autor']); ?>" required><br><br>

    <label>Preço:</label><br>
    <input type="number" name="preco" min="0" value="<?php echo htmlspecialchars($livro['preco']); ?>" required><br><br>

    <label>Estoque:</label><br>
    <input type="number" name="estoque" min="0" value="<?php echo htmlspecialchars($livro['estoque']); ?>" required><br><br>

    <button type="submit">Salvar alterações</button>
</form>
