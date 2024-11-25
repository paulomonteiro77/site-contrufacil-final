<?php
session_start();
$id = $_POST['id'];
$nome = $_POST['nome'];
$preco = $_POST['preco'];

if(!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

$produto = [
    'id' => $id,
    'nome' => $nome,
    'preco' => $preco,
    'quantidade' => 1
];

$produtoExistente = false;
foreach($_SESSION['carrinho'] as &$item) {
    if($item['id'] == $id) {
        $item['quantidade'] += 1;
        $produtoExistente = true;
        break;
    }
}

if(!$produtoExistente) {
    $_SESSION['carrinho'][] = $produto;
}

echo json_encode($_SESSION['carrinho']);
?>
