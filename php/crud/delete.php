<?php
require '../conexao/conexao.php';
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

    $stmtImagem = $pdo->prepare("SELECT imagem FROM livros WHERE id = :id");
    $stmtImagem->bindParam(':id', $id);
    $stmtImagem->execute();
    $livro = $stmtImagem->fetch(PDO::FETCH_ASSOC);

    if ($livro) {
        $caminhoImagem = '../../uploads/' . $livro['imagem'];

        if (file_exists($caminhoImagem)) {
            unlink($caminhoImagem);
        }
        

        $sqlVendas = "DELETE FROM vendas WHERE livro_id = :id";
        $stmtVendas = $pdo->prepare($sqlVendas);
        $stmtVendas->bindParam(':id', $id);
        $stmtVendas->execute();


        $sql = "DELETE FROM livros WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);


        if ($stmt->execute()) {
            header("location: ../login&cadastro/admin.php");
        } else {
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Erro ao excluir o livro.',
                    showConfirmButton: true
                }).then(() => {
                    window.location.href = '../login&cadastro/admin.php';
                });
            </script>";
        }
    } else {
        echo "
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Livro não encontrado',
                text: 'Não foi possível localizar o livro para exclusão.',
                showConfirmButton: true
            }).then(() => {
                window.location.href = '../login&cadastro/admin.php';
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
            window.location.href = '../login&cadastro/admin.php';
        });
    </script>";
}
?>

</body>
</html>
