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
                <a href="index.html">Leyo<span>+</span></a>
            </div>
            <form action="/Biblioteca/php/functions/pgPesquisa.php" method="get">
                <input type="text" name="busca" placeholder="Pesquise aqui" autocomplete="off">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
            <nav class="main-nav">
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="AboutUs.html">Sobre Nós</a></li>
                    <li><a href="cadastro.html">Cadastrar-se</a></li>
                    <li><a href="login.html">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <main class="book-container">
        <section class="book-main-info">
            <div class="book-cover-container">
                <img src="../uploads/<?= htmlspecialchars($livro['imagem']) ?>" alt="<?= htmlspecialchars($livro['titulo']) ?>" class="book-cover">
            </div>
            
            <div class="book-details">
                <h1 class="book-title"><?= htmlspecialchars($livro['titulo']) ?></h1>
                <p class="book-genre"><?= htmlspecialchars($livro['nome_categoria']) ?></p>
                <p class="book-author"><?= htmlspecialchars($livro['nome_autor']) ?></p>
                
                <div class="book-description">
                    <p><?= nl2br(htmlspecialchars($livro['descricao'])) ?></p>
                    <div>
                        <button>COMPRAR <p>R$valor</p></button>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="related-books">
            <h2 class="section-title">Livros similares</h2>
            <div class="related-books-grid">
                <div class="related-book">
                    <img src="../images/placeholder-book.jpg" alt="Livro relacionado">
                    <p>Título do Livro</p>
                </div>
                <div class="related-book">
                    <img src="../images/placeholder-book.jpg" alt="Livro relacionado">
                    <p>Título do Livro</p>
                </div>
                <div class="related-book">
                    <img src="../images/placeholder-book.jpg" alt="Livro relacionado">
                    <p>Título do Livro</p>
                </div>
                <div class="related-book">
                    <img src="../images/placeholder-book.jpg" alt="Livro relacionado">
                    <p>Título do Livro</p>
                </div>
            </div>
        </section>
    </main>
    
</body>
</html>