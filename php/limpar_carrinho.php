<?php
session_start();
unset($_SESSION['carrinho']);
unset($_SESSION['frete']);
unset($_SESSION['endereco']);
header("Location: carrinho.php");
exit();
?>
