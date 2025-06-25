<?php
require '../conexao/conexao.php';

$stmtCategorias = $pdo->query("SELECT id, nome FROM categorias ORDER BY nome ASC");
$categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        window.onload = () => {
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'ID não especificado.'
            }).then(() => {
                window.location.href = '../login&cadastro/admin.php';
            });
        };
    </script>";
    exit;
}

$id = (int)$_GET['id'];
$sql = "SELECT * FROM livros WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$livro = $stmt->fetch();

if (!$livro) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        window.onload = () => {
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Livro não encontrado.'
            }).then(() => {
                window.location.href = '../login&cadastro/admin.php';
            });
        };
    </script>";
    exit;
}

$stmtAutor = $pdo->prepare("SELECT nome FROM autores WHERE id = :id");
$stmtAutor->execute([':id' => $livro['autor_id']]);
$autor = $stmtAutor->fetchColumn();

$stmtEditora = $pdo->prepare("SELECT nome FROM editoras WHERE id = :id");
$stmtEditora->execute([':id' => $livro['editora_id']]);
$editora = $stmtEditora->fetchColumn();

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
    $autor_id = $stmt->fetchColumn();
    if (!$autor_id) {
        $stmt = $pdo->prepare("INSERT INTO autores (nome) VALUES (:nome)");
        $stmt->execute([':nome' => $autor_nome]);
        $autor_id = $pdo->lastInsertId();
    }

    $stmt = $pdo->prepare("SELECT id FROM editoras WHERE nome = :nome");
    $stmt->execute([':nome' => $editora_nome]);
    $editora_id = $stmt->fetchColumn();
    if (!$editora_id) {
        $stmt = $pdo->prepare("INSERT INTO editoras (nome) VALUES (:nome)");
        $stmt->execute([':nome' => $editora_nome]);
        $editora_id = $pdo->lastInsertId();
    }

    $imagemParaSalvar = $livro['imagem'];
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagemTmp = $_FILES['imagem']['tmp_name'];
        $nomeImagem = uniqid() . '-' . basename($_FILES['imagem']['name']);
        $pastaUploads = '../../uploads/';
        $caminhoDestino = $pastaUploads . $nomeImagem;

        if (!is_dir($pastaUploads)) mkdir($pastaUploads, 0777, true);

        if (move_uploaded_file($imagemTmp, $caminhoDestino)) {
            if (!empty($livro['imagem']) && file_exists($pastaUploads . $livro['imagem'])) {
                unlink($pastaUploads . $livro['imagem']);
            }
            $imagemParaSalvar = $nomeImagem;
        }
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
    $stmt->execute([
        ':titulo' => $titulo,
        ':preco' => $preco,
        ':estoque' => $estoque,
        ':descricao' => $descricao,
        ':ano_publicacao' => $ano_publicacao,
        ':categoria_id' => $categoria_id,
        ':autor_id' => $autor_id,
        ':editora_id' => $editora_id,
        ':imagem' => $imagemParaSalvar,
        ':id' => $id
    ]);

    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        window.onload = () => {
            Swal.fire({
                icon: 'success',
                title: 'Livro atualizado com sucesso!',
                timer: 2000,
                showConfirmButton: false,
                timerProgressBar: true
            }).then(() => {
                window.location.href = '../login&cadastro/admin.php';
            });
        };
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit | leyo+</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../../styles/create&delete.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header class="main-header">
        <div class="header-content">
            <div class="logo"><a href="../../index.php">Leyo<span>+</span></a></div>
            <form action="/Biblioteca/php/functions/pgPesquisa.php" method="get">
                <input type="text" name="busca" placeholder="Pesquise o livro" autocomplete="off">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
            <nav class="main-nav">
                <ul>
                    <li><a href="../login&cadastro/admin.php">Voltar</a></li>
                    <li><a href="../login&cadastro/logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="book-form">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-main-content">
                <div class="image-upload-section">
                    <div class="image-placeholder">
                        <img id="preview-imagem"
                             src="<?= !empty($livro['imagem']) && file_exists('../../uploads/' . $livro['imagem']) ? '../../uploads/' . htmlspecialchars($livro['imagem']) : '#' ?>"
                             alt="Prévia da imagem"
                             style="<?= !empty($livro['imagem']) && file_exists('../../uploads/' . $livro['imagem']) ? 'display:block;' : 'display:none;' ?>">
                    </div>
                    <label for="image-upload-input" class="edit-photo-btn">Editar foto</label>
                    <input type="file" name="imagem" id="image-upload-input" accept="image/*" style="display: none;">

                    <!-- Bloco único para evitar campos invisíveis inválidos -->
                    <div class="author-publisher-mobile">
                        <div class="form-group">
                            <input type="text" name="autor_nome" required placeholder="Nome Autor"
                                   value="<?= htmlspecialchars($autor ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" name="editora_nome" required placeholder="Editora"
                                   value="<?= htmlspecialchars($editora ?? '') ?>">
                        </div>
                    </div>
                </div>

                <div class="book-details-section">
                    <div class="book-header">
                        <div class="form-group book-title-input">
                            <input type="text" name="titulo" required placeholder="Book Title"
                                   value="<?= htmlspecialchars($livro['titulo']) ?>">
                        </div>
                        <div class="form-group book-category-select">
                            <select name="categoria_id" required>
                                <option value="">Tema Único</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?= $categoria['id'] ?>" <?= $categoria['id'] == $livro['categoria_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($categoria['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group book-description-textarea">
                        <textarea name="descricao" required placeholder="Descrição..."><?= htmlspecialchars($livro['descricao']) ?></textarea>
                    </div>

                    <div class="form-row price-stock-inputs">
                        <div class="form-group">
                            <input type="number" name="estoque" min="0" required placeholder="Estoque"
                                   value="<?= htmlspecialchars($livro['estoque']) ?>">
                        </div>
                        <div class="form-group">
                            <input type="number" name="preco" min="0" step="0.01" required placeholder="Preço"
                                   value="<?= htmlspecialchars($livro['preco']) ?>">
                        </div>
                    </div>

                    <div class="form-group publication-year-input">
                        <input type="number" name="ano_publicacao" min="1000" max="2025" required placeholder="Ano de Publicação"
                               value="<?= htmlspecialchars($livro['ano_publicacao']) ?>">
                    </div>
                </div>
            </div>

            <p class="attention-note">ATENÇÃO: Preencha todos os campos.</p>
            <button type="submit" class="submit-btn save-btn">Salvar alterações</button>
        </form>
    </div>

    <script>
        document.getElementById('image-upload-input').addEventListener('change', function (event) {
            const input = event.target;
            const preview = document.getElementById('preview-imagem');
            const editButton = document.querySelector('.edit-photo-btn');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
            editButton.textContent = 'Editar foto';
        });
    </script>
</body>
</html>
