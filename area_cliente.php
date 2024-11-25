<?php
session_start();
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área do Cliente - ConstruFácil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>ConstruFácil: Área do Cliente</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="produtos.php">Produtos</a></li>
                <li><a href="area_cliente.php">Área do Cliente</a></li>
                <li><a href="carrinho.html">Carrinho</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Bem-vindo, <?php echo $_SESSION['cliente_nome']; ?>!</h2>
        <p>Esta é a sua área do cliente.</p>
        <a href="php/logout.php">Sair</a>
    </main>
    <footer>
        <p>&copy; ConstruFácil. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
