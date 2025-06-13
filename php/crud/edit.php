<?php
require '../conexao/conexao.php';

$stmtCategorias = $pdo->query("SELECT id, nome FROM categorias ORDER BY nome ASC");
$categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM livros WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $livro = $stmt->fetch();

    if (!$livro) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Livro não encontrado.'
            }).then(() => {
                window.location.href = '../login&cadastro/admin.php';
            });
        </script>";
        exit;
    }
} else {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Erro',
            text: 'ID não especificado.'
        }).then(() => {
            window.location.href = '../login&cadastro/admin.php';
        });
    </script>";
    exit;
}

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
            if (!empty($livro['imagem']) && file_exists($livro['imagem'])) {
                unlink($livro['imagem']);
            }
            $imagemParaSalvar = $nomeImagem;
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Erro ao mover o arquivo de imagem.'
                });
            </script>";
            exit;
        }
    } else {
        $imagemParaSalvar = $livro['imagem'];
    }

    $sql = "UPDATE livros SET 
                titulo = :titulo,
                preco = :preco,
                estoque = :estoque,
                descricao = :descricao,
                ano_publicacao = :ano_publicacao,
                categoria_id = :categoria_id,
                autor_id = :autor_id,
                editora_id = :editora_id,
                imagem = :imagem
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':estoque', $estoque);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':ano_publicacao', $ano_publicacao);
    $stmt->bindParam(':categoria_id', $categoria_id);
    $stmt->bindParam(':autor_id', $autor_id);
    $stmt->bindParam(':editora_id', $editora_id);
    $stmt->bindParam(':imagem', $imagemParaSalvar);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: 'Livro atualizado com sucesso!',
                timer: 2500,
                showConfirmButton: false,
                timerProgressBar: true
            }).then(() => {
                window.location.href = '../login&cadastro/admin.php';
            });
        </script>";
        exit;
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Erro ao atualizar o livro.'
            }).then(() => {
                window.location.href = 'edit.php?id={$id}';
            });
        </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Livro</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-popup {
            font-family: Arial, sans-serif !important;
        }
        img.preview {
            max-width: 150px;
            margin-bottom: 10px;
            display: block;
        }
    </style>
</head>
<body>

<form method="POST" action="edit.php?id=<?php echo $livro['id']; ?>" enctype="multipart/form-data">
    <label>Título do livro:</label><br>
    <input type="text" name="titulo" value="<?php echo htmlspecialchars($livro['titulo']); ?>" required><br><br>

    <label>Preço:</label><br>
    <input type="number" name="preco" min="0" step="0.01" value="<?php echo htmlspecialchars($livro['preco']); ?>" required><br><br>

    <label>Estoque:</label><br>
    <input type="number" name="estoque" min="0" value="<?php echo htmlspecialchars($livro['estoque']); ?>" required><br><br>

    <label>Ano de publicação:</label><br>
    <input type="number" name="ano_publicacao" min="1000" value="<?php echo htmlspecialchars($livro['ano_publicacao']); ?>" required><br><br>

    <label>Descrição:</label><br>
    <textarea name="descricao" rows="4" cols="50" required><?php echo htmlspecialchars($livro['descricao']); ?></textarea><br><br>

    <label>Categoria:</label><br>
    <select name="categoria_id" required>
        <option value="">Selecione uma categoria</option>
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?= $categoria['id'] ?>" <?php if($categoria['id'] == $livro['categoria_id']) echo 'selected'; ?>>
                <?= htmlspecialchars($categoria['nome']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Nome do Autor:</label><br>
    <?php
        $stmtAutor = $pdo->prepare("SELECT nome FROM autores WHERE id = :id");
        $stmtAutor->execute([':id' => $livro['autor_id']]);
        $autor = $stmtAutor->fetchColumn();
    ?>
    <input type="text" name="autor_nome" value="<?php echo htmlspecialchars($autor ?: ''); ?>" required><br><br>

    <label>Nome da Editora:</label><br>
    <?php
        $stmtEditora = $pdo->prepare("SELECT nome FROM editoras WHERE id = :id");
        $stmtEditora->execute([':id' => $livro['editora_id']]);
        $editora = $stmtEditora->fetchColumn();
    ?>
    <input type="text" name="editora_nome" value="<?php echo htmlspecialchars($editora ?: ''); ?>" required><br><br>

    <label>Imagem atual:</label><br>
    <?php if (!empty($livro['imagem']) && file_exists('../../uploads/' . $livro['imagem'])): ?>
        <img src="../../uploads/<?php echo $livro['imagem']; ?>" alt="Imagem do livro" class="preview">
    <?php else: ?>
        <p>Sem imagem</p>
    <?php endif; ?>

    <label>Alterar imagem (opcional):</label><br>
    <input type="file" name="imagem" accept="image/*"><br><br>

    <button type="submit">Salvar alterações</button>
</form>

</body>
</html>
