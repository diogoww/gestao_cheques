<?php
// fornecedores/delete.php
session_start();
if (!isset($_SESSION['user_id'])) { 
    header('Location: ../auth/login.php'); 
    exit; 
}

require_once __DIR__ . '/../database/connect.php';

$id = intval($_GET['id'] ?? 0);

if ($id) {
    // Verifica se existem cheques vinculados ao fornecedor
    $stmt = $conn->prepare("SELECT COUNT(*) FROM cheques WHERE fornecedor_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // Redireciona com parâmetro de erro
        header("Location: list.php?error=fornecedor_has_cheques");
        exit;
    } else {
        // Deleta fornecedor
        $stmt = $conn->prepare("DELETE FROM fornecedores WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }
}

header('Location: list.php');
exit;