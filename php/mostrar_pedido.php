<?php
include 'conexao.php';

// Buscar pedidos do banco de dados
$sql = "SELECT * FROM pedidos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos Feitos</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1>Pedidos Feitos</h1>
        <nav>
            <ul>
                <li><a href="../admin/painel.html">Painel</a></li>
            </ul>   
        </nav>
    </header>
    <main>
        <section class="pedidos">
            <h2>Lista de Pedidos</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome do Cliente</th>
                        <th>Email do Cliente</th>
                        <th>Data do Pedido</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["nome_cliente"]; ?></td>
                                <td><?php echo $row["email_cliente"]; ?></td>
                                <td><?php echo $row["data_pedido"]; ?></td>
                                <td>R$ <?php echo number_format($row["total"], 2, ',', '.'); ?></td>
                                <td><?php echo $row["status"]; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Nenhum pedido encontrado</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer>
        <p>&copy; ConstruFácil. Todos os direitos reservados.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
