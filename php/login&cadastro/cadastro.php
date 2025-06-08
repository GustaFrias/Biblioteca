<?php
require 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>leyo ++</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    .swal2-popup {
        font-family: Arial, sans-serif !important;
    }
</style>

</head>
<body>

<?php
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
                window.location.href = '../htmls/index.html';
            });
        </script>";
        exit;
    }

    $sqlCheck = "SELECT id FROM clientes WHERE email = :email";
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
                window.location.href = '../htmls/index.html';
            });
        </script>";
        exit;
    }

    $data_cadastro = date('Y-m-d H:i:s');
    $sql = "INSERT INTO Clientes (nome, email, senha, data_cadastro) 
            VALUES (:nome, :email, :senha, :data_cadastro)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':data_cadastro', $data_cadastro);

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
                window.location.href = '../htmls/login.html';
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
                window.location.href = '../htmls/index.html';
            });
        </script>";
        exit;
    }
}
//ola mundo
//juidnaijhdaudhnaisndjashdnuiandiuandiuansidnaiudaw


?>

</body>
</html>
