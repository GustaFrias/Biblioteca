<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../../htmls/login.html");
    exit;
}
?>