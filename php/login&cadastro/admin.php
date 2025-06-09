<?php
require 'verifica.php';
require '../conexao/conexao.php';

$sql = "SELECT * FROM livros";
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
<a href="../crud/create.php">Cadastrar novo livro</a> | <a href="logout.php">Sair</a>
<hr>

<?php foreach ($livros as $livro): ?>
    <div>
        <h3><?php echo htmlspecialchars($livro['titulo']); ?></h3>
        <p><strong>Autor:</strong> <?php echo htmlspecialchars($livro['autor']); ?></p>
        <p><strong>Preço:</strong> R$ <?php echo htmlspecialchars($livro['preco']); ?></p>
        <p><strong>Em Estoque:</strong> <?php echo htmlspecialchars($livro['estoque']); ?></p>

        <?php if (!empty($livro['imagem'])): ?>
                <img src="<?php echo htmlspecialchars($livro['imagem']); ?>" alt="Capa do livro" style="max-width: 150px; border: 1px solid #ccc; padding: 4px;">
        <?php endif; ?>

        <br>
        <a href="edit.php?id=<?php echo $livro['id']; ?>">Editar</a> |
        <a href="#" onclick="confirmarExclusao(<?php echo $livro['id']; ?>)">Deletar</a>
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
            window.location.href = 'delete.php?id=' + id;
        }
    });
}
</script>

</body>
</html>
