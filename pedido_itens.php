<?php
    // Importa o arquivo de configuração
    include 'config.php';

    // Verificar se o ID do pedido foi fornecido
    if (!isset($_GET['pedido_id'])) {
        die('Pedido não encontrado.');
    }

    $pedido_id = $_GET['pedido_id'];

    // Buscar detalhes dos itens do pedido
    $query = $pdo->prepare("
        SELECT pi.id, p.nome AS produto, pi.quantidade, pi.preco_unitario, (pi.quantidade * pi.preco_unitario) AS total_item
        FROM pedido_items pi
        JOIN produtos p ON pi.produto_id = p.id
        WHERE pi.pedido_id = ?
    ");
    $query->execute([$pedido_id]);
    $itens = $query->fetchAll(PDO::FETCH_ASSOC);

    // Buscar informações do pedido
    $pedido_query = $pdo->prepare("
        SELECT p.id, c.nome AS cliente, p.data_pedido, p.total
        FROM pedidos p
        JOIN clientes c ON p.cliente_id = c.id
        WHERE p.id = ?
    ");
    $pedido_query->execute([$pedido_id]);
    $pedido_info = $pedido_query->fetch(PDO::FETCH_ASSOC);

    if (!$pedido_info) {
        die('Pedido não encontrado.');
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Itens do Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="lista_pedidos.php">Lista de Pedidos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pedido.php">Fazer Pedido</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cliente.php">Fazer Cadastro</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="produto.php">Cadastrar Produto</a>
                </li>   
            </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1 class="mt-5">Itens do Pedido #<?= $pedido_info['id'] ?></h1>
        <p><strong>Cliente:</strong> <?= $pedido_info['cliente'] ?></p>
        <p><strong>Data do Pedido:</strong> <?= $pedido_info['data_pedido'] ?></p>
        <p><strong>Total do Pedido:</strong> R$ <?= number_format($pedido_info['total'], 2, ',', '.') ?></p>

        <h2 class="mt-4">Itens</h2>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Foreach para listar os os itens -->
                <?php foreach ($itens as $item): ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= $item['produto'] ?></td>
                        <td><?= $item['quantidade'] ?></td>
                        <td>R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?></td>
                        <td>R$ <?= number_format($item['total_item'], 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
