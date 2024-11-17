<?php
    // Importa o arquivo de configuração
    include 'config.php';

    // Listar clientes e produtos
    $clientes = $pdo->query("SELECT id, nome FROM clientes")->fetchAll(PDO::FETCH_ASSOC);
    $produtos = $pdo->query("SELECT id, nome, preco FROM produtos")->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $cliente_id = $_POST['cliente_id'];
        $produto_id = $_POST['produto_id'];
        $quantidade = $_POST['quantidade'];

        // Buscar o preço do produto selecionado
        $produto = $pdo->prepare("SELECT preco FROM produtos WHERE id = ?");
        $produto->execute([$produto_id]);
        $preco = $produto->fetchColumn();

        // Calcular o total do pedido
        $total = $quantidade * $preco;

        // Inserir pedido
        $stmt = $pdo->prepare("INSERT INTO pedidos (cliente_id, data_pedido, total) VALUES (?, NOW(), ?)");
        $stmt->execute([$cliente_id, $total]);
        $pedido_id = $pdo->lastInsertId();

        // Inserir itens do pedido
        $stmt_item = $pdo->prepare("INSERT INTO pedido_items (pedido_id, produto_id, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");
        $stmt_item->execute([$pedido_id, $produto_id, $quantidade, $preco]);

        echo "Pedido realizado com sucesso!";
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Pedido</title>
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
        <h1 class="mt-5">Criar Pedido</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="cliente_id" class="form-label">Cliente</label>
                <select class="form-control" id="cliente_id" name="cliente_id" required>
                    <!-- Mostra todos os clientes cadastrados no select -->
                    <?php foreach ($clientes as $cliente): ?>
                        <option value="<?= $cliente['id'] ?>"><?= $cliente['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="produto_id" class="form-label">Produto</label>
                <select class="form-control" id="produto_id" name="produto_id" required>
                    <!-- Mostra todos os produtos cadastrados no select -->
                    <?php foreach ($produtos as $produto): ?>
                        <option value="<?= $produto['id'] ?>"><?= $produto['nome'] ?> (R$ <?= $produto['preco'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="quantidade" class="form-label">Quantidade</label>
                <input type="number" class="form-control" id="quantidade" name="quantidade" required>
            </div>
            <button type="submit" class="btn btn-primary">Criar Pedido</button>
        </form>
    </div>
</body>
</html>
