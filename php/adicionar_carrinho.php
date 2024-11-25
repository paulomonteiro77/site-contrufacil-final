<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    
    $produto = ['id' => $id, 'nome' => $nome, 'preco' => $preco, 'quantidade' => 1];

    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    $produtoExistente = false;
    foreach ($_SESSION['carrinho'] as &$item) {
        if ($item['id'] == $id) {
            $item['quantidade'] += 1;
            $produtoExistente = true;
            break;
        }
    }

    if (!$produtoExistente) {
        $_SESSION['carrinho'][] = $produto;
    }

    header("Location: ../index.html");
    exit();
}
?>
