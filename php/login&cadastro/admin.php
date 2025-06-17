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


    <meta charset="UTF-8" />
    <link rel="stylesheet" href="../../styles/admin.css" />
    <title>Painel Administrativo</title>
    <form action="/Biblioteca/php/functions/pgPesquisa.php" method="get" onsubmit="return validarBusca()">
    <input type="text" id="barraBusca" name="busca" placeholder="Pesquise aqui" autocomplete="off" oninput="buscarInstantaneamente()"/> 
    </form>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        #barraBusca {
            margin-bottom: 20px;
            padding: 8px;
            width: 100%;
            max-width: 400px;
            font-size: 16px;
        }
    </style>
    
</head>

<body>

    <?php
    if (isset($_SESSION['msg_sucesso'])) {
        echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: '" . $_SESSION['msg_sucesso'] . "',
            timer: 2500,
            showConfirmButton: false,
            timerProgressBar: true
        });
    </script>";
        unset($_SESSION['msg_sucesso']);
    }

    if (isset($_SESSION['msg_erro'])) {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: '" . $_SESSION['msg_erro'] . "'
        });
    </script>";
        unset($_SESSION['msg_erro']);
    }
    ?>

    <h1>Área Administrativa - Lista de Livros</h1>



    <p>
        <a href="../crud/create.php"
            style="text-decoration: none; padding: 8px 15px; background-color: #28a745; color: white; border-radius: 5px;">Cadastrar
            novo livro</a>
        |
        <a href="../login&cadastro/logout.php"
            style="text-decoration: none; padding: 8px 15px; background-color: #6c757d; color: white; border-radius: 5px;">Sair</a>
    </p>
    <hr>

    <div class="organization" id="listaLivros">
        <?php foreach ($livros as $livro): ?>
            <div class="book-card" data-titulo="<?= strtolower(htmlspecialchars($livro['titulo'])); ?>">
                <?php if (!empty($livro['imagem'])): ?>
                    <div class="book-card-image">
                        <img src="../../uploads/<?= htmlspecialchars($livro['imagem']); ?>" alt="Capa do livro" />
                    </div>
                <?php endif; ?>
                <div class="book-card-details">
                    <h3><?= htmlspecialchars($livro['titulo']); ?></h3>
                    <p><strong>Descrição:</strong> <?= nl2br(htmlspecialchars($livro['descricao'])); ?></p>
                    <p><strong>Preço:</strong> R$ <?= number_format($livro['preco'], 2, ',', '.'); ?></p>
                    <p><strong>Em Estoque:</strong> <?= htmlspecialchars($livro['estoque']); ?></p>
                    <p><strong>Categoria:</strong> <?= htmlspecialchars($livro['categoria_nome'] ?? 'Não categorizado'); ?></p>
                    <p><strong>Ano de publicação:</strong> <?= htmlspecialchars($livro['ano_publicacao']); ?></p>
                    <div class="book-card-actions">
                        <a href="../crud/edit.php?id=<?= $livro['id']; ?>">Editar</a>
                        <a href="#" onclick="confirmarExclusao(<?= $livro['id']; ?>)">Deletar</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

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