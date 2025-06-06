<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    .swal2-popup {
        font-family: Arial, sans-serif !important;
    }
</style>
</head>
<body>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Logout realizado!',
        text: 'Você saiu da sua conta.',
        timer: 2000,
        showConfirmButton: false,
        timerProgressBar: true
    }).then(() => {
        window.location.href = '../htmls/login.html';
    });
</script>
</body>
</html>
