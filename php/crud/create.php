<?php
require '../conexao/conexao.php';

$stmtCategorias = $pdo->query("SELECT id, nome FROM categorias ORDER BY nome ASC");
$categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    .swal2-popup {
        font-family: Arial, sans-serif !important;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = $_POST['titulo'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];
    $descricao = $_POST['descricao'];
    $ano_publicacao = $_POST['ano_publicacao'];
    $categoria_id = $_POST['categoria_id'];
    $autor_nome = trim($_POST['autor_nome']);
    $editora_nome = trim($_POST['editora_nome']);

    $stmt = $pdo->prepare("SELECT id FROM autores WHERE nome = :nome");
    $stmt->execute([':nome' => $autor_nome]);
    $autor = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($autor) {
        $autor_id = $autor['id'];
    } else {
        $stmt = $pdo->prepare("INSERT INTO autores (nome) VALUES (:nome)");
        $stmt->execute([':nome' => $autor_nome]);
        $autor_id = $pdo->lastInsertId();
    }

    $stmt = $pdo->prepare("SELECT id FROM editoras WHERE nome = :nome");
    $stmt->execute([':nome' => $editora_nome]);
    $editora = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($editora) {
        $editora_id = $editora['id'];
    } else {
        $stmt = $pdo->prepare("INSERT INTO editoras (nome) VALUES (:nome)");
        $stmt->execute([':nome' => $editora_nome]);
        $editora_id = $pdo->lastInsertId();
    }

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagemTmp = $_FILES['imagem']['tmp_name'];
        $nomeImagem = uniqid() . '-' . basename($_FILES['imagem']['name']);
        $pastaUploads = '../../uploads/';
        $caminhoDestino = $pastaUploads . $nomeImagem;

        if (!is_dir($pastaUploads)) {
            mkdir($pastaUploads, 0777, true);
        }

        if (move_uploaded_file($imagemTmp, $caminhoDestino)) {
            $sql = "INSERT INTO livros (titulo, preco, estoque, imagem, descricao, ano_publicacao, categoria_id, autor_id, editora_id) 
                    VALUES (:titulo, :preco, :estoque, :imagem, :descricao, :ano_publicacao, :categoria_id, :autor_id, :editora_id)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':estoque', $estoque);
            $stmt->bindParam(':imagem', $nomeImagem);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':ano_publicacao', $ano_publicacao);
            $stmt->bindParam(':categoria_id', $categoria_id);
            $stmt->bindParam(':autor_id', $autor_id);
            $stmt->bindParam(':editora_id', $editora_id);
            if ($stmt->execute()) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Livro cadastrado com sucesso!',
                            timer: 2500,
                            showConfirmButton: false,
                            timerProgressBar: true
                        }).then(() => {
                            window.location.href = '..//login&cadastro/admin.php';});
                        });

                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro ao salvar no banco de dados.'
                    });
                </script>";
            }
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Erro ao mover o arquivo de imagem.'
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Imagem não enviada ou inválida.'
            });
        </script>";
    }
}
?>

<form method="POST" action="create.php" enctype="multipart/form-data">
    <label>Título do livro:</label><br>
    <input type="text" name="titulo" required><br><br>

    <label>Preço:</label><br>
    <input type="number" name="preco" min="0" step="0.01" required><br><br>

    <label>Estoque:</label><br>
    <input type="number" name="estoque" min="0" required><br><br>

    <label>Ano de publicação:</label><br>
    <input type="number" name="ano_publicacao" min="1000" required><br><br>

    <label>Descrição:</label><br>
    <textarea name="descricao" rows="4" cols="50" required></textarea><br><br>

    <label>Categoria:</label><br>
    <select name="categoria_id" required>
        <option value="">Selecione uma categoria</option>
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['nome']) ?></option>
        <?php endforeach; ?>
    </select><br><br>
     
    <label>Nome do Autor:</label><br>
    <input type="text" name="autor_nome" required><br><br>

    <label>Nome da Editora:</label><br>
    <input type="text" name="editora_nome" required><br><br>

    <label>Imagem:</label><br>
    <input type="file" name="imagem" accept="image/*" required><br><br>

    <button type="submit">Cadastrar Livro</button>
</form>