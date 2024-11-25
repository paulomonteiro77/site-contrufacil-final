<?php
session_start();

$carrinho = isset($_SESSION['carrinho']) ? $_SESSION['carrinho'] : [];
$valorFrete = 0;
$endereco = '';
$mensagem_compra = isset($_SESSION['mensagem_compra']) ? $_SESSION['mensagem_compra'] : '';

// Limpar mensagem de compra após exibir
unset($_SESSION['mensagem_compra']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cepDestino'])) {
    $cepDestino = $_POST['cepDestino'];

    // Validar o formato do CEP
    if (preg_match('/^[0-9]{5}-?[0-9]{3}$/', $cepDestino)) {
        // Usando a API ViaCEP para buscar o endereço
        $url = "https://viacep.com.br/ws/$cepDestino/json/";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if (!isset($data['erro'])) {
            $endereco = $data['logradouro'] . ", " . $data['bairro'] . ", " . $data['localidade'] . " - " . $data['uf'];
            // Simulação do cálculo de frete
            $valorFrete = rand(10, 50);
            $_SESSION['frete'] = $valorFrete;
            $_SESSION['endereco'] = $endereco;
        } else {
            $endereco = "CEP não encontrado.";
        }
    } else {
        $endereco = "Formato de CEP inválido.";
    }
}

$totalProdutos = array_reduce($carrinho, function($total, $produto) {
    return $total + ($produto['preco'] * $produto['quantidade']);
}, 0);
$valorFrete = isset($_SESSION['frete']) ? $_SESSION['frete'] : 0;
$endereco = isset($_SESSION['endereco']) ? $_SESSION['endereco'] : '';
$totalComFrete = $totalProdutos + $valorFrete;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras - ConstruFácil</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1>ConstruFácil: Carrinho de Compras</h1>
        <nav>
            <ul>
                <li><a href="../index.html">Home</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="carrinho">
            <h2>Itens no Carrinho</h2>
            <?php if ($mensagem_compra): ?>
                <div class="mensagem-compra">
                    <p><?php echo htmlspecialchars($mensagem_compra); ?></p>
                </div>
            <?php endif; ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($carrinho)): ?>
                        <tr>
                            <td colspan="4">O carrinho está vazio.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($carrinho as $produto): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($produto['nome']); ?></td>
                                <td><?php echo htmlspecialchars($produto['quantidade']); ?></td>
                                <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                                <td>R$ <?php echo number_format($produto['preco'] * $produto['quantidade'], 2, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Total dos Produtos</td>
                        <td>R$ <?php echo number_format($totalProdutos, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3">Frete</td>
                        <td>R$ <?php echo number_format($valorFrete, 2, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3"><strong>Total Geral</strong></td>
                        <td><strong>R$ <?php echo number_format($totalComFrete, 2, ',', '.'); ?></strong></td>
                    </tr>
                </tfoot>
            </table>
            <div class="cep-section">
                <form action="carrinho.php" method="post">
                    <label for="cepDestino">CEP de Destino:</label>
                    <input type="text" id="cepDestino" name="cepDestino" required>
                    <button type="submit">Calcular Frete</button>
                </form>
            </div>
            <?php if ($endereco): ?>
                <div class="endereco">
                    <p>Endereço: <?php echo htmlspecialchars($endereco); ?></p>
                </div>
            <?php endif; ?>
            <div class="buttons">
                <form action="finalizar_compra.php" method="post">
                    <button type="submit" class="button">Finalizar Compra</button>
                </form>
                <form action="limpar_carrinho.php" method="post">
                    <button type="submit" class="button">Limpar Carrinho</button>
                </form>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; ConstruFácil. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
