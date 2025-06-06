<?php
require 'conexao.php';
?>

<style>
    .swal2-popup {
        font-family: Arial, sans-serif !important;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagemTmp = $_FILES['imagem']['tmp_name'];
        $nomeImagem = uniqid() . '-' . basename($_FILES['imagem']['name']);
        $pastaUploads = 'uploads/';
        $caminhoDestino = $pastaUploads . $nomeImagem;

        if (!is_dir($pastaUploads)) {
            mkdir($pastaUploads, 0777, true);
        }

        if (move_uploaded_file($imagemTmp, $caminhoDestino)) {
            $sql = "INSERT INTO livros (titulo, autor, preco, estoque, imagem) VALUES (:titulo, :autor, :preco, :estoque, :imagem)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':autor', $autor);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':estoque', $estoque);
            $stmt->bindParam(':imagem', $caminhoDestino);

            if ($stmt->execute()) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Livro cadastrado com sucesso!',
                            timer: 2500,
                            showConfirmButton: false,
                            timerProgressBar: true
                        }).then(() => {
                            window.location.href = 'admin.php';
                        });
                    });
                </script>";
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Erro ao salvar no banco de dados.'
                        });
                    });
                </script>";
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Erro ao mover o arquivo de imagem.'
                    });
                });
            </script>";
        }
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Imagem não enviada ou inválida.'
                });
            });
        </script>";
    }
}
?>

<form method="POST" action="create.php" enctype="multipart/form-data">
    <label>Título do livro:</label><br>
    <input type="text" name="titulo" required><br><br>

    <label>Autor:</label><br>
    <input type="text" name="autor" required><br><br>

    <label>Preço:</label><br>
    <input type="number" name="preco" min="0" step="0.01" required><br><br>

    <label>Estoque:</label><br>
    <input type="number" name="estoque" min="0" required><br><br>

    <label>Imagem:</label><br>
    <input type="file" name="imagem" accept="image/*" required><br><br>

    <button type="submit">Cadastrar Livro</button>
</form>
