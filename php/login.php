<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificar se o usuário existe no banco de dados
    $sql = "SELECT * FROM clientes WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verificar a senha
        if (password_verify($senha, $row['senha'])) {
            // Login bem-sucedido
            $_SESSION['cliente_id'] = $row['id'];
            $_SESSION['cliente_nome'] = $row['nome'];
            header("Location: ../area_cliente.php");
            exit();
        } else {
            // Senha incorreta
            $error = "Senha incorreta!";
        }
    } else {
        // Usuário não encontrado
        $error = "Usuário não encontrado!";
    }

    header("Location: ../login.html?error=" . urlencode($error));
    exit();
} else {
    $error = "Método de requisição inválido!";
    header("Location: ../login.html?error=" . urlencode($error));
    exit();
}

$conn->close();
?>
