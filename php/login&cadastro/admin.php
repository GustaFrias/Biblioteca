<?php
require 'verifica.php';
require '../conexao/conexao.php';

$sql = "SELECT livros.*, categorias.nome AS categoria_nome
        FROM livros
        LEFT JOIN categorias ON livros.categoria_id = categorias.id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$livros = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Admin - Leyo +</title>
    <link rel="stylesheet" href="../../styles/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <header class="main-header">
        <div class="header-content">
            <div class="logo">
                <a href="../../index.php">Leyo<span>+</span></a>
            </div>
            <form action="/Biblioteca/php/functions/pgPesquisa.php" method="get" onsubmit="return validarBusca()">

                <input type="text" id="barraBusca" name="busca" placeholder="Pesquise aqui" autocomplete="off"
                    oninput="buscarInstantaneamente()">
                <button type="submit"><i class="fas fa-search"></i></button>

            </form>

            <div class="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <nav class="main-nav">
                <ul>
                    <li><a href="../crud/create.php">Cadastrar</a></li>
                    <li><a href="../login&cadastro/logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>

        <div class="organization" id="listaLivros">
            <?php foreach ($livros as $livro): ?>
            <div class="book-card" data-titulo="<?= strtolower(htmlspecialchars($livro['titulo'])); ?>">
                <?php if (!empty($livro['imagem'])): ?>
                <div class="book-card-image">
                    <img src="../../uploads/<?= htmlspecialchars($livro['imagem']); ?>" alt="Capa do livro" />
                </div>
                <?php endif; ?>
                <div class="book-card-details">
                    <h3>
                        <?= htmlspecialchars($livro['titulo']); ?>
                    </h3>
                    <p><strong>Preço:</strong> R$
                        <?= number_format($livro['preco'], 2, ',', '.'); ?>
                    </p>
                    <p><strong>Em Estoque:</strong>
                        <?= htmlspecialchars($livro['estoque']); ?>
                    </p>
                    <p><strong>Categoria:</strong>
                        <?= htmlspecialchars($livro['categoria_nome'] ?? 'Não categorizado'); ?>
                    </p>
                    <p><strong>Ano de publicação:</strong>
                        <?= htmlspecialchars($livro['ano_publicacao']); ?>
                    </p>
                    <div class="book-card-actions">
                        <a href="../crud/edit.php?id=<?= $livro['id']; ?>">Editar</a>
                        <a href="#" onclick="confirmarExclusao(<?= $livro['id']; ?>)">Deletar</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

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

    <script>
        function confirmarExclusao(id) {
            Swal.fire({
                title: 'Tem certeza?',
                text: "Você não poderá reverter isso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, deletar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../crud/delete.php?id=' + id;
                }
            });
        }

        document.getElementById('barraBusca').addEventListener('input', function () {
            const termoBusca = this.value.toLowerCase();
            const livros = document.querySelectorAll('#listaLivros .book-card');

            livros.forEach(function (livro) {
                const titulo = livro.getAttribute('data-titulo');
                if (titulo.includes(termoBusca)) {
                    livro.style.display = '';
                } else {
                    livro.style.display = 'none';
                }
            });
        });
    </script>

</body>

</html>