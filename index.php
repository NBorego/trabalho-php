<?php
    // Importa o arquivo de configuração
    include 'config.php';

    // Pega todos os produtos presentes no banco de dados
    $query = $pdo->query("SELECT * FROM produtos");
    $produtos = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
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
        <h1 class="mt-5">Lista de Produtos</h1>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                </tr>
            </thead>
            <tbody>
                <!-- Faz um for para mostrar os produtos na tabela -->
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?= $produto['id'] ?></td>
                        <td><?= $produto['nome'] ?></td>
                        <td><?= $produto['preco'] ?></td>
                        <td><?= $produto['estoque'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
