<?php
// fornecedores/list.php
session_start();
if (!isset($_SESSION['user_id'])) { 
    header('Location: ../auth/login.php'); exit; 
}
require_once __DIR__ . '/../database/connect.php';

$result = $conn->query("SELECT * FROM fornecedores ORDER BY id ASC");
?>

<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Fornecedores - Cheque Master</title>
  <?php include __DIR__ . '/../includes/header.php'; ?>
</head>
<body>
    <?php include __DIR__ . '/../includes/navbar.php'; ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Fornecedores</h3>
            <a class="btn btn-primary" href="create.php">Novo Fornecedor</a>
        </div>

        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Cidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($f = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $f['id'] ?></td>
                    <td><?= htmlspecialchars($f['nome']) ?></td>
                    <td><?= htmlspecialchars($f['telefone']) ?></td>
                    <td><?= htmlspecialchars($f['cidade']) ?></td>
                    <td>
                        <a class="btn btn-sm btn-warning" href="edit.php?id=<?= $f['id'] ?>">Editar</a>
                        <a class="btn btn-sm btn-danger" href="delete.php?id=<?= $f['id'] ?>" onclick="return confirm('Remover fornecedor?')">Excluir</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
