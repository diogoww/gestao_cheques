<?php
session_start();

if (!isset($_SESSION['user_id'])) {
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
    <?php include __DIR__ . '/includes/header.php'; ?>
</head>
<body>
    <?php include __DIR__ . '/includes/navbar.php'; ?>

    <div class="container mt-4 text-center">

        <h2 class="mb-4">Grupo Rocha - Cheque Master</h2>
        <p>Bem-vindo, <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>!</p>

        <!-- BOTÕES GRANDES -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-4 mb-3">
                <a href="/gestao_cheques/fornecedores/list.php" class="text-decoration-none">
                    <div class="card p-4 menu-card text-center">
                        <h3 class="mb-0">📦 Fornecedores</h3>
                    </div>
                </a>
            </div>

            <div class="col-md-4 mb-3">
                <a href="/gestao_cheques/cheques/list.php" class="text-decoration-none">
                    <div class="card p-4 menu-card text-center">
                        <h3 class="mb-0">💰 Cheques</h3>
                    </div>
                </a>
            </div>
        </div>


        <!-- DASHBOARD -->
        <div class="row mt-5">
            <div class="col-md-4">
                <div class="card p-3">
                    <h5>Total de Fornecedores</h5>
                    <?php
                    require __DIR__ . '/database/connect.php';
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
                    <h5>Cheques vencidos</h5>
                    <?php
                    $res = $conn->query("SELECT COUNT(*) as c FROM cheques WHERE data_vencimento < CURDATE() AND data_pagamento IS NULL");
                    $c = $res->fetch_assoc()['c'] ?? 0;
                    ?>
                    <h2><?= $c ?></h2>
                </div>
            </div>
        </div>

    </div>

    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
