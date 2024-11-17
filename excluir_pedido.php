<?php
include 'config.php';

$pedido_id = $_GET['pedido_id'] ?? null;

if ($pedido_id) {
    try {
        $pdo->beginTransaction();

        // Exclui os itens do pedido
        $stmt_items = $pdo->prepare("DELETE FROM pedido_items WHERE pedido_id = ?");
        $stmt_items->execute([$pedido_id]);

        // Exclui o pedido
        $stmt_pedido = $pdo->prepare("DELETE FROM pedidos WHERE id = ?");
        $stmt_pedido->execute([$pedido_id]);

        $pdo->commit();

        echo "<script>alert('Pedido excluído com sucesso!'); window.location.href='lista_pedidos.php';</script>";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<script>alert('Erro ao excluir pedido: {$e->getMessage()}'); window.location.href='lista_pedidos.php';</script>";
    }
} else {
    echo "<script>alert('Pedido não encontrado!'); window.location.href='lista_pedidos.php';</script>";
}
