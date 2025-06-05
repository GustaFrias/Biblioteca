<?php
require 'conexao.php';
$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];
        
    $sql = "INSERT INTO livros (titulo, autor, preco, estoque) VALUES (:titulo, :autor, :preco, :estoque)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':autor', $autor);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':estoque', $estoque);

    if ($stmt->execute()) {
        $mensagem = "Livro cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar o livro.";
    }
}
?>

<form method="POST" action="create.php" enctype="multipart/form-data">
    <label>Título do livro:</label><br>
    <input type="text" name="titulo" required><br><br>

    <label>Autor:</label><br>
    <input type="text" name="autor" required><br><br>

    <label>Preço:</label><br>
    <input type="number" name="preco" min="0" required><br><br>

    <label>Estoque:</label><br>
    <input type="number" name="estoque" min="0" required><br><br>

    <button type="submit">Cadastrar Livro</button>
</form>

<?php
if (!empty($mensagem)) {
    echo "<p>$mensagem</p>";
}
?>
