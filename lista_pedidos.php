<?php
// Importa o arquivo de configuração
include 'config.php';

// Buscar todos os pedidos
$query = $pdo->query("
    SELECT p.id, c.nome AS cliente, p.data_pedido, p.total
    FROM pedidos p
    JOIN clientes c ON p.cliente_id = c.id
");
$pedidos = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Confirmação de exclusão
        function confirmarExclusao() {
            return confirm('Tem certeza que deseja excluir este pedido?');
        }
    </script>
</head>
<body>
    <!-- Navbar -->
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
                    <a class="nav-link" href="lista_pedidos.php">Lista de Pedidos</a>
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
        <h1 class="mt-5">Lista de Pedidos</h1>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Data do Pedido</th>
                    <th>Total</th>
                    <th>Itens</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?= $pedido['id'] ?></td>
                        <td><?= $pedido['cliente'] ?></td>
                        <td><?= $pedido['data_pedido'] ?></td>
                        <td>R$ <?= number_format($pedido['total'], 2, ',', '.') ?></td>
                        <td>
                            <a href="pedido_itens.php?pedido_id=<?= $pedido['id'] ?>" class="btn btn-info btn-sm">Ver Itens</a>
                        </td>
                        <td>
                            <a href="editar_pedido.php?pedido_id=<?= $pedido['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="excluir_pedido.php?pedido_id=<?= $pedido['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirmarExclusao()">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
