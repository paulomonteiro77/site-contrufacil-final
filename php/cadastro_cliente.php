<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../php/conexao.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
$endereco = $_POST['endereco'];
$cep = $_POST['cep'];

$sql = "INSERT INTO clientes (nome, email, senha, endereco, cep) VALUES ('$nome', '$email', '$senha', '$endereco', '$cep')";

if ($conn->query($sql) === TRUE) {
    header("Location: ../login.html");
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
