<?php
// Importa o arquivo de configuração
include 'config.php';

// Obtém o ID do pedido da URL
$pedido_id = $_GET['pedido_id'] ?? null;

// Verifica se o formulário foi enviado para editar o pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editar'])) {
        // Obtém os dados enviados pelo formulário
        $cliente_id = $_POST['cliente_id'];
        $data_pedido = $_POST['data_pedido'];
        $total = $_POST['total'];

        // Atualiza o pedido no banco de dados
        $stmt = $pdo->prepare("UPDATE pedidos SET cliente_id = ?, data_pedido = ?, total = ? WHERE id = ?");
        $stmt->execute([$cliente_id, $data_pedido, $total, $pedido_id]);

        echo "<script>alert('Pedido atualizado com sucesso!'); window.location.href='lista_pedidos.php';</script>";
    } elseif (isset($_POST['excluir'])) {
        // Exclui o pedido do banco de dados
        $stmt = $pdo->prepare("DELETE FROM pedidos WHERE id = ?");
        $stmt->execute([$pedido_id]);

        echo "<script>alert('Pedido excluído com sucesso!'); window.location.href='lista_pedidos.php';</script>";
    }
}

// Obtém os dados do pedido para exibição
$stmt = $pdo->prepare("SELECT * FROM pedidos WHERE id = ?");
$stmt->execute([$pedido_id]);
$pedido = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtém a lista de clientes para o dropdown
$clientes = $pdo->query("SELECT id, nome FROM clientes")->fetchAll(PDO::FETCH_ASSOC);

// Verifica se o pedido existe
if (!$pedido) {
    echo "<script>alert('Pedido não encontrado!'); window.location.href='lista_pedidos.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Editar Pedido</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="cliente_id" class="form-label">Cliente</label>
                <select class="form-control" id="cliente_id" name="cliente_id">
                    <?php foreach ($clientes as $cliente): ?>
                        <option value="<?= $cliente['id'] ?>" <?= $cliente['id'] == $pedido['cliente_id'] ? 'selected' : '' ?>>
                            <?= $cliente['nome'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="data_pedido" class="form-label">Data do Pedido</label>
                <input type="date" class="form-control" id="data_pedido" name="data_pedido" value="<?= $pedido['data_pedido'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="total" class="form-label">Total</label>
                <input type="number" class="form-control" id="total" name="total" step="0.01" value="<?= $pedido['total'] ?>" required>
            </div>
            <button type="submit" name="editar" class="btn btn-success">Salvar Alterações</button>
            <button type="submit" name="excluir" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este pedido?')">Excluir</button>
            <a href="lista_pedidos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
