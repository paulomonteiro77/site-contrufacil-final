<?php
session_start();
include 'conexao.php';

// Verifica se o carrinho existe e não está vazio
if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
    $_SESSION['mensagem_compra'] = "Seu carrinho está vazio!";
    header("Location: carrinho.php");
    exit;
}

// Inserir os detalhes do pedido na tabela 'pedidos'
$sql_pedido = "INSERT INTO pedidos (data_pedido) VALUES (NOW())";

if ($conn->query($sql_pedido) === TRUE) {
    $pedido_id = $conn->insert_id;

    // Inserir cada item do carrinho na tabela 'itens_pedido'
    foreach ($_SESSION['carrinho'] as $item) {
        $produto_id = $item['id'];
        $quantidade = $item['quantidade'];
        $preco = $item['preco'];

        // Verificar se o produto existe na tabela 'produtos'
        $sql_verifica_produto = "SELECT id FROM produtos WHERE id = $produto_id";
        $result = $conn->query($sql_verifica_produto);

        if ($result->num_rows > 0) {
            $sql_item = "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario) 
                         VALUES ($pedido_id, $produto_id, $quantidade, $preco)";
            
            if (!$conn->query($sql_item)) {
                $_SESSION['mensagem_compra'] = "Erro ao inserir item no pedido: " . $conn->error;
                header("Location: carrinho.php");
                exit;
            }
        } else {
            $_SESSION['mensagem_compra'] = "Produto com ID $produto_id não encontrado.";
            header("Location: carrinho.php");
            exit;
        }
    }

    // Limpar o carrinho de compras
    unset($_SESSION['carrinho']);
    $_SESSION['mensagem_compra'] = "Compra finalizada com sucesso! Número do pedido: " . $pedido_id;
} else {
    $_SESSION['mensagem_compra'] = "Erro ao inserir pedido: " . $conn->error;
}

$conn->close();
header("Location: carrinho.php");
exit();
?>
