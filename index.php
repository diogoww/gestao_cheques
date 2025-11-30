<?php
session_start();

if (!isset($_SESSION['user_id'])){
    header('Location: /gestao_cheques/auth/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Cheque Master</title>
    <?php include
        __DIR__ . '/includes/header.php';
    ?>
</head>
<body>
    <?php include __DIR__ . '/cheques/includes/navbar.php'; ?>

    <div class="container mt-4">
        <h3>Bem-vindo, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h3>
        <p>Use o menu acima para acessar os módulos de Fornecedores e Cheques.</p>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card p-3">
                    <h5>Total de Fornecedores</h5>
                    <?php
                    require __DIR__ . '/cheques/db/connect.php';
                    $res = $conn->query("SELECT COUNT(*) as c FROM fornecedores");
                    $c = $res->fetch_assoc()['c'] ?? 0;
                    ?>
                    <h2><?= $c ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <h5>Total de Cheques</h5>
                    <?php
                    $res = $conn->query("SELECT COUNT(*) as c FROM cheques");
                    $c = $res->fetch_assoc()['c'] ?? 0;
                    ?>
                    <h2><?= $c ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <h5>Cheques vencidos (emitidos)</h5>
                    <?php
                    $res = $conn->query("SELECT COUNT(*) as c FROM cheques WHERE data_vencimento < CURDATE() AND data_pagamento IS NULL");
                    $c = $res->fetch_assoc()['c'] ?? 0;
                    ?>
                    <h2><?= $c ?></h2>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/cheques/includes/footer.php'; ?>
</body>
</html>