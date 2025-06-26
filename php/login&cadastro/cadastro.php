<?php
require '../conexao/conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];

    if ($senha !== $confirma_senha) {
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Vish!',
                text: 'As senhas não estão iguais.'
            }).then(() => {
                window.location.href = '../../index.php';
            });
        </script>";
        exit;
    }

    $sqlCheck = "SELECT id FROM usuarios WHERE email = :email";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->bindParam(':email', $email);
    $stmtCheck->execute();

    if ($stmtCheck->rowCount() > 0) {
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: 'E-mail já cadastrado.'
            }).then(() => {
                window.location.href = '../../index.php';
            });
        </script>";
        exit;
    }

    $sql = "INSERT INTO usuarios (nome, email, senha) 
            VALUES (:nome, :email, :senha)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);


    if ($stmt->execute()) {
        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Cadastro realizado!',
                text: 'Redirecionando para o login...',
                timer: 2500,
                showConfirmButton: false,
                timerProgressBar: true
            }).then(() => {
                window.location.href = '../../htmls/login.html';
            });
        </script>";
        exit;
    } else {
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: 'Erro ao cadastrar no banco de dados.'
            }).then(() => {
                window.location.href = '../../index.php';
            });
        </script>";
        exit;
    }
}
?>

</body>
</html>
