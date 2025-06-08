<?php
require 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Excluir Livro</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    .swal2-popup {
        font-family: Arial, sans-serif !important;
    }
</style>
</head>
<body>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM livros WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: 'Livro excluído com sucesso!',
                timer: 2500,
                showConfirmButton: false,
                timerProgressBar: true
            }).then(() => {
                window.location.href = '../php/admin.php';
            });
        </script>";
    } else {
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: 'Erro ao excluir o livro.',
                showConfirmButton: true
            }).then(() => {
                window.location.href = '../php/admin.php';
            });
        </script>";
    }
} else {
    echo "
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Aviso!',
            text: 'ID não especificado.',
            showConfirmButton: true
        }).then(() => {
            window.location.href = '../php/admin.php';
        });
    </script>";
}
?>

</body>
</html>

