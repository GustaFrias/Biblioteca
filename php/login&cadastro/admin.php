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
    <title>Painel Administrativo</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>    
        .swal2-popup {
            font-family: Arial, sans-serif !important;
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
<a href="../crud/create.php">Cadastrar novo livro</a> | <a href="../login&cadastro/logout.php">Sair</a>
<hr>

<?php foreach ($livros as $livro): ?>
    <div>
        <h3><?= htmlspecialchars($livro['titulo']); ?></h3>
        <p><strong>Descrição:</strong> <?= nl2br(htmlspecialchars($livro['descricao'])); ?></p>
        <p><strong>Preço:</strong> R$ <?= htmlspecialchars($livro['preco']); ?></p>
        <p><strong>Em Estoque:</strong> <?= htmlspecialchars($livro['estoque']); ?></p>
        <p><strong>Categoria:</strong> <?= htmlspecialchars($livro['categoria_nome'] ?? 'Não categorizado'); ?></p>
        <p><strong>Ano de publicação:</strong> <?= htmlspecialchars($livro['ano_publicacao']); ?></p>

        <?php if (!empty($livro['imagem'])): ?>
            <img src="<?= htmlspecialchars($livro['imagem']); ?>" alt="Capa do livro" style="max-width: 150px; border: 1px solid #ccc; padding: 4px;">
        <?php endif; ?>

        <br>
        <a href="../crud/edit.php?id=<?= $livro['id']; ?>">Editar</a> |
        <a href="#" onclick="confirmarExclusao(<?= $livro['id']; ?>)">Deletar</a>
    </div>
    <hr>
<?php endforeach; ?>

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
</script>

</body>
</html>
