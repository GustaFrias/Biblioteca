<?php
require '../conexao/conexao.php';

$stmtCategorias = $pdo->query("SELECT id, nome FROM categorias ORDER BY nome ASC");
$categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);

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
    $autor_id = $autor ? $autor['id'] : (function () use ($pdo, $autor_nome) {
        $stmt = $pdo->prepare("INSERT INTO autores (nome) VALUES (:nome)");
        $stmt->execute([':nome' => $autor_nome]);
        return $pdo->lastInsertId();
    })();

    $stmt = $pdo->prepare("SELECT id FROM editoras WHERE nome = :nome");
    $stmt->execute([':nome' => $editora_nome]);
    $editora = $stmt->fetch(PDO::FETCH_ASSOC);
    $editora_id = $editora ? $editora['id'] : (function () use ($pdo, $editora_nome) {
        $stmt = $pdo->prepare("INSERT INTO editoras (nome) VALUES (:nome)");
        $stmt->execute([':nome' => $editora_nome]);
        return $pdo->lastInsertId();
    })();

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
                    window.addEventListener('load', () => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Livro cadastrado com sucesso!',
                            timer: 2500,
                            showConfirmButton: false,
                            timerProgressBar: true
                        }).then(() => {
                            window.location.href = '../login&cadastro/admin.php';
                        });
                    });
                </script>";
            } else {
                echo "<script>
                    window.addEventListener('load', () => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro ao salvar no banco de dados.'
                        });
                    });
                </script>";
            }
        } else {
            echo "<script>
                window.addEventListener('load', () => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro ao mover o arquivo de imagem.'
                    });
                });
            </script>";
        }
    } else {
        echo "<script>
            window.addEventListener('load', () => {
                Swal.fire({
                    icon: 'error',
                    title: 'Imagem não enviada ou inválida.'
                });
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create | leyo+</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../../styles/create&delete.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header class="main-header">
        <div class="header-content">
            <div class="logo">
                <a href="../../index.php">Leyo<span>+</span></a>
            </div>
            <form action="/Biblioteca/php/functions/pgPesquisa.php" method="get">
                <input type="text" name="busca" placeholder="Pesquise o livro" autocomplete="off">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
            <div class="menu-toggle"><span></span><span></span><span></span></div>
            <nav class="main-nav">
                <ul><li><a href="#">Logout</a></li></ul>
            </nav>
        </div>
    </header>

    <div class="book-form">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-main-content">
                <div class="image-upload-section">
                    <div class="image-placeholder">
                        <img id="preview-imagem" src="#" alt="Prévia da imagem" style="display:none;">
                    </div>
                    <label for="image-upload-input" class="edit-photo-btn">Inserir Capa</label>
                    <input type="file" name="imagem" id="image-upload-input" accept="image/*" required style="display: none;">
                </div>

                <div class="book-details-section">
                    <div class="book-header">
                        <div class="form-group book-title-input">
                            <input type="text" name="titulo" required placeholder="Book Title">
                        </div>
                        <div class="form-group book-category-select">
                            <select name="categoria_id" required>
                                <option value="">Tema Único</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['nome']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group book-description-textarea">
                        <textarea name="descricao" required placeholder="ESCREVA O ENREDO..."></textarea>
                    </div>

                    <div class="form-row price-stock-inputs">
                        <div class="form-group">
                            <input type="number" name="estoque" min="0" required placeholder="Estoque">
                        </div>
                        <div class="form-group">
                            <input type="number" name="preco" min="0" step="0.01" required placeholder="Preço">
                        </div>
                    </div>

                    <div class="form-group publication-year-input">
                        <input type="number" name="ano_publicacao" min="1000" max="2025" required placeholder="Ano de Publicação">
                    </div>

                    <!-- ✅ Campo único de autor e editora (corrigido) -->
                    <div class="form-row">
                        <div class="form-group">
                            <input type="text" name="autor_nome" required placeholder="Nome Autor">
                        </div>
                        <div class="form-group">
                            <input type="text" name="editora_nome" required placeholder="Editora">
                        </div>
                    </div>
                </div>
            </div>

            <p class="attention-note">ATENÇÃO: Preencha todos os campos.</p>
            <button type="submit" class="submit-btn save-btn">Cadastrar Livro</button>
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
                    editButton.textContent = 'Trocar Capa';
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
                editButton.textContent = 'Trocar Capa';
            }
        });
    </script>
</body>

</html>
