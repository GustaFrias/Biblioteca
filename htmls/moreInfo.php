<?php
session_start();
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


$sqlRelacionados = "SELECT livros.*, autores.nome AS nome_autor
                     FROM livros
                     LEFT JOIN autores ON livros.autor_id = autores.id
                     WHERE livros.categoria_id = :categoria_id AND livros.id != :id
                     LIMIT 4";

$stmtRelacionados = $pdo->prepare($sqlRelacionados);
$stmtRelacionados->execute([
    ':categoria_id' => $livro['categoria_id'],
    ':id' => $id
]);
$relacionados = $stmtRelacionados->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../styles/moreInfo.css">
    <title><?= htmlspecialchars($livro['titulo']) ?> | Leyo+</title>
</head>
<body>
    <header class="main-header">
        <div class="header-content">
            <div class="logo">
                <a href="../index.php">Leyo<span>+</span></a>
            </div>
            <form action="/Biblioteca/php/functions/pgPesquisa.php" method="get">
                <input type="text" name="busca" placeholder="Pesquise aqui" autocomplete="off">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
            
            <div class="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <nav class="main-nav">
                <ul>
                  <ul id="nav-list">
                       <?php if (!isset($_SESSION['usuario']) && !isset($_SESSION['admin'])): ?>
                        <li><a href="cadastro.html">Cadastrar-se</a></li>
                        <li><a href="login.html">Login</a></li>
                        <li><a href="../index.php">Home</a></li>
                    <?php else: ?>
                        <li>
                            <li><a href="../index.php">Home</a></li>
                            <li><a href="AboutUs.php">Sobre nós</a></li>
                            <img src="../img/iconLogin.png" alt="" id="icon-login"
                                style="width: 50px; height: auto; margin-top: -13px; margin-right: -30px;">
                        </li>
                        <li>
                            <?php if (isset($_SESSION['admin'])): ?>
                                <li><a href="../php/login&cadastro/admin.php">Administrador</a></li>
                            <?php elseif (isset($_SESSION['usuario'])): ?>
                                <?= htmlspecialchars($_SESSION['usuario']) ?>
                            <?php endif; ?>
                        </li>
                        <li><a href="../php/login&cadastro/logout.php">Sair</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    
    <main class="page-container">
        <div class="content-wrapper">
            <section class="book-main-info">
                <div class="book-cover-section">
                    <div class="book-cover-container">
                        <img src="../uploads/<?= htmlspecialchars($livro['imagem']) ?>" alt="<?= htmlspecialchars($livro['titulo']) ?>" class="book-cover">
                    </div>
                    <p class="book-author">Autor: <?= htmlspecialchars($livro['nome_autor']) ?></p>
                    <p class="book-publisher">Editora: <?= htmlspecialchars($livro['nome_editora']) ?></p>
                </div>
                
                <div class="book-details">
                    <h1 class="book-title"><?= htmlspecialchars($livro['titulo']) ?></h1>
                    <p class="book-genre"><?= htmlspecialchars($livro['nome_categoria']) ?></p>
                    
                    <div class="book-description">
                        <p><?= nl2br(htmlspecialchars($livro['descricao'])) ?></p>
                    </div>

                    <div class="purchase-section">
                        <button class="buy-button">
                            COMPRAR
                            <span><span>R$<?= number_format($livro['preco'], 2, ',', '.') ?></span></span>
                        </button>
                    </div>
                </div>
            </section>
            
            <section class="related-books">
                <h2 class="section-title">Livros similares</h2>
                <div class="related-books-grid">
                    <div class="related-book">
                        <div class="related-book-cover"></div>
                        <p>Título</p>
                    </div>
                    <div class="related-book">
                        <div class="related-book-cover"></div>
                        <p>Título</p>
                    </div>
                    <div class="related-book">
                        <div class="related-book-cover"></div>
                        <p>Título</p>
                    </div>
                    <div class="related-book">
                        <div class="related-book-cover"></div>
                        <p>Título</p>
                    </div>
                    <div class="related-book">
                        <div class="related-book-cover"></div>
                        <p>Título</p>
                </div>
            </section>
        </div>
    </main>
    <footer>
        <div id="footer_items">
            <span id="copyright">
                © 2025 <span class="">Leyo</span><span class="">+</span>
            </span>
            <div class="footer_infos">
                <div class="">Entre em Contato:</div>
                <div class="">(11) 98765-4321</div>
                <div class="">Leyo+</div>
            </div>
            <div class="social-media-buttons">
                <a href=""><i class="fa-brands fa-facebook"></i></a>
                <a href=""><i class="fa-brands fa-instagram"></i></a>
                <a href=""><i class="fa-brands fa-x-twitter"></i></a>
            </div>
        </div>
    </footer>
    
    <script>
        const menuToggle = document.querySelector('.menu-toggle');
        const mainNav = document.querySelector('.main-nav ul');

        menuToggle.addEventListener('click', () => {
            menuToggle.classList.toggle('active');
            mainNav.classList.toggle('active');
        });
    </script>
</body>
</html>