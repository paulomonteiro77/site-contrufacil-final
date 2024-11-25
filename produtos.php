<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'php/conexao.php'; // Caminho correto
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - ConstruFácil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>ConstruFácil: Produtos</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="produtos.php">Produtos</a></li>
                <li><a href="cadastro_cliente.html">Área do Cliente</a></li>
                <li><a href="carrinho.html">Carrinho</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="produtos">
            <h2>Lista de Produtos</h2>
            <?php
            $sql = "SELECT * FROM produtos";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table border='1'><tr><th>Nome</th><th>Descrição</th><th>Preço</th><th>Estoque</th></tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["nome"]. "</td>
                            <td>" . $row["descricao"]. "</td>
                            <td>" . $row["preco"]. "</td>
                            <td>" . $row["estoque"]. "</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>0 resultados</p>";
            }

            $conn->close();
            ?>
        </section>
    </main>
    <footer>
        <p>&copy; ConstruFácil. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
