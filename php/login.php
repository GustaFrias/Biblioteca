<?php
session_start();
require 'conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Autenticação</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    body{
        background-color: #A66E4E;
    }

    .swal2-popup {
        font-family: Arial, sans-serif !important;
    }
</style>

</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $entrada = trim($_POST['email']);
    $senha = $_POST['senha'];


    $sqlAdm = "SELECT * FROM usuarios_adm WHERE nome = :nome AND senha = :senha";
    $stmtAdm = $pdo->prepare($sqlAdm);
    $stmtAdm->bindParam(':nome', $entrada);
    $stmtAdm->bindParam(':senha', $senha);
    $stmtAdm->execute();

    if ($stmtAdm->rowCount() > 0) {
        $admin = $stmtAdm->fetch();
        $_SESSION['admin'] = true;
        $_SESSION['nome'] = $admin['nome'];
        ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Login realizado!',
                text: 'Bem-vindo, <?php echo $admin['nome']; ?>!',
                timer: 2500,
                showConfirmButton: false,
                timerProgressBar: true
            }).then(() => {
                window.location.href = '../php/admin.php';
            });
        </script>
        <?php
        exit;
    }

    $sqlUser = "SELECT * FROM clientes WHERE email = :email AND senha = :senha";
    $stmtUser = $pdo->prepare($sqlUser);
    $stmtUser->bindParam(':email', $entrada);
    $stmtUser->bindParam(':senha', $senha);
    $stmtUser->execute();

    if ($stmtUser->rowCount() > 0) {
        $usuario = $stmtUser->fetch();
        $_SESSION['usuario'] = $usuario['nome'];
        $_SESSION['usuario_id'] = $usuario['id'];
        ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Login realizado!',
                text: 'Bem-vindo(a), <?php echo $usuario['nome']; ?>!',
                timer: 2500,
                showConfirmButton: false,
                timerProgressBar: true
            }).then(() => {
                window.location.href = '../php/usuario_area.php';
            });
        </script>
        <?php
        exit;
    } else {
        ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: 'Usuário ou senha inválidos.',
                timer: 2500,
                showConfirmButton: false,
                timerProgressBar: true
            }).then(() => {
                window.location.href = '../htmls/login.html';
            });
        </script>
        <?php
        exit;
    }
}
?>
</body>
</html>
