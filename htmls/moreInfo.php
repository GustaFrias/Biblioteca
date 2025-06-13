<?php
require '../php/conexao/conexao.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Livro não encontrado.";
    exit;
}

$id = (int) $_GET['id'];

$sql = "SELECT livros.*, autores.nome AS nome_autor, categorias.nome AS nome_categoria, editoras.nome AS nome_editora
        FROM livros
        LEFT JOIN autores ON livros.autor_id = autores.id
        LEFT JOIN categorias ON livros.categoria_id = categorias.id
        LEFT JOIN editoras ON livros.editora_id = editoras.id
        WHERE livros.id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$livro = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$livro) {
    echo "Livro não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mais Informações sobre o livro</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.html"> Leyo<span> +</span> </a>
        </div>
        <form action="../php/functions/navbar.php" method="POST">

            <input type="text">
            <span>pesquise aqui</span>
            <span class="">
                <i class="fas fa-search"></i>
            </span>
        </form>
        <nav>
            <ul id="nav-list">
                <li><a href="index.html">Home</a></li>
                <li><a href="AboutUs.html">Sobre Nós</a></li>
                <li><a href="cadastro.html">Cadastrar-se</a></li>
                <li><a href="login.html">Login</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <div class="imgLivroPrincipal"><img src="../uploads/<?php echo htmlspecialchars($livro['imagem']); ?>" alt="<?= htmlspecialchars($livro['imagem']) ?>" width="200"></div>
        
        <h1><?= htmlspecialchars($livro['titulo']) ?></h1>
        <p><strong>Autor:</strong> <?= htmlspecialchars($livro['nome_autor']) ?></p>
        <p><strong>Categoria:</strong> <?= htmlspecialchars($livro['nome_categoria']) ?></p>
        <p><strong>Editora:</strong> <?= htmlspecialchars($livro['nome_editora']) ?></p>
        <p><strong>Descrição:</strong> <?= nl2br(htmlspecialchars($livro['descricao'])) ?></p>

        <hr class="hr">
        <div class="imglivrosRelacionados"></div>
        <div class="imglivrosRelacionados"></div>
        <div class="imglivrosRelacionados"></div>
        <div class="imglivrosRelacionados"></div>
    </div>
    <footer>
        <div id="footer_items">
            <span id="copyright">
                © 2025 <span class="">Leyo</span><span class="">+</span>
            </span>
            <div class="footer_infos">
                <div class="">Entre em Contato:</div>
                <div class=""> (11) 98765-4321</div>
                <div class="">Leyo+</div>
            </div>
            <div class="social-media-buttons">
                <a href="">
                    <i class="fa-brands fa-facebook"></i>
                </a>
                <a href="">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
            </div>
        </div>
    </footer>
</body>
</html>