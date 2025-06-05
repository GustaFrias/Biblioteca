<?php
session_start();
session_destroy();
header("Location: ../htmls/login.php");
exit;
?>
