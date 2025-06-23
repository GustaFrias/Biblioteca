<?php
require '../php/conexao/conexao.php';

//verifica se o id tá na url, se n tiver ou n for númerico exibe a mensagem
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Livro não encontrado.";
    exit;
}
//converte o id em inteiro pra evitar sqlinjection
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

// livros relacionados
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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($livro['titulo']) ?> - Mais Informações</title>
    <link rel="stylesheet" href="../styles/moreInfo.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="../index.php">Leyo<span> +</span></a>
        </div>
        <form action="/Biblioteca/php/functions/pgPesquisa.php" method="get">
            <input type="text" name="busca" placeholder="Pesquise aqui"/>
        </form>
        <nav>
            <ul id="nav-list">
                <li><a href="../index.php">Home</a></li>
                <li><a href="../htmls/AboutUs.php">Sobre Nós</a></li>
                <li><a href="../htmls/cadastro.html">Cadastrar-se</a></li>
                <li><a href="../htmls/login.html">Login</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="imgLivroPrincipal">
            <img src="../uploads/<?= htmlspecialchars($livro['imagem']) ?>" alt="<?= htmlspecialchars($livro['titulo']) ?>" width="200">
        </div>
        
        <h1><?= htmlspecialchars($livro['titulo']) ?></h1>
        <p><strong>Autor:</strong> <?= htmlspecialchars($livro['nome_autor']) ?></p>
        <p><strong>Categoria:</strong> <?= htmlspecialchars($livro['nome_categoria']) ?></p>
        <p><strong>Editora:</strong> <?= htmlspecialchars($livro['nome_editora']) ?></p>
        <p><strong>Descrição:</strong> <?= nl2br(htmlspecialchars($livro['descricao'])) ?></p>
        <p><strong>Preço:</strong> R$ <?= number_format($livro['preco'], 2, ',', '.') ?></p>
        <p><strong>Estoque:</strong> <?= htmlspecialchars($livro['estoque']) ?> unidades</p>

        <hr class="hr">

        <h2>Livros Relacionados</h2>
        <div class="livros-relacionados">
            <?php if ($relacionados): ?>
                <?php foreach ($relacionados as $rel): ?>
                    <div class="card-livro">
                        <a href="moreInfo.php?id=<?= $rel['id'] ?>">
                            <img src="../uploads/<?= htmlspecialchars($rel['imagem']) ?>" alt="<?= htmlspecialchars($rel['titulo']) ?>" width="120">
                            <h3><?= htmlspecialchars($rel['titulo']) ?></h3>
                            <p><?= htmlspecialchars($rel['nome_autor']) ?></p>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Não há livros relacionados nesta categoria.</p>
            <?php endif; ?>
        </div>
    </div>

    
</body>
</html>