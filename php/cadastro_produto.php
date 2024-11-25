<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];
    $imagem = $_FILES['imagem']['name'];

    $target_dir = "../imagens/";
    $target_file = $target_dir . basename($_FILES["imagem"]["name"]);
    move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file);

    $sql = "INSERT INTO produtos (nome, descricao, preco, estoque, imagem) VALUES ('$nome', '$descricao', $preco, $estoque, '$imagem')";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../admin/listar_produtos.html");
        exit();
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
