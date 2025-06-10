<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login&cadastro/login.html");
    exit;
}
?>
