<?php
require_once '../conexao/conexao.php';
header('Content-Type: application/json');

try {
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        throw new Exception('ID inválido');
    }

    $id = (int) $_POST['id'];

    $sql = "SELECT estoque, preco FROM livros WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $livro = $stmt->fetch();

    if (!$livro) {
        throw new Exception('Livro não encontrado');
    }

    if ($livro['estoque'] <= 0) {
        throw new Exception('Livro fora de estoque');
    }

    $sqlUpdate = "UPDATE livros SET estoque = estoque - 1 WHERE id = :id";
    $stmtUpdate = $pdo->prepare($sqlUpdate);
    if (!$stmtUpdate->execute([':id' => $id])) {
        throw new Exception('Falha ao atualizar estoque');
    }

    $sqlVenda = "INSERT INTO vendas (livro_id, data_venda, quantidade, preco_unitario)
                 VALUES (:livro_id, NOW(), 1, :preco)";
    $stmtVenda = $pdo->prepare($sqlVenda);
    if (!$stmtVenda->execute([':livro_id' => $id, ':preco' => $livro['preco']])) {
        throw new Exception('Falha ao registrar venda');
    }

    echo json_encode(['status' => 'sucesso', 'mensagem' => 'Compra realizada com sucesso!']);
} catch (Exception $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
}