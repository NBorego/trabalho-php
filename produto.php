<?php
    // Importa o arquivo de configuração
    include 'config.php';

    // Verifica se o método de requisição é POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $estoque = $_POST['estoque'];

        // Código sql
        $stmt = $pdo->prepare("INSERT INTO produtos (nome, preco, estoque) VALUES (?, ?, ?)");

        // Verifica se possui erro
        if ($stmt->execute([$nome, $preco, $estoque])) {
            echo "Produto cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar produto.";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
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
        <h1 class="mt-5">Cadastrar Produto</h1>
        <!-- Formulário -->
        <form method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="preco" class="form-label">Preço</label>
                <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
            </div>
            <div class="mb-3">
                <label for="estoque" class="form-label">Estoque</label>
                <input type="number" class="form-control" id="estoque" name="estoque" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
</body>
</html>
