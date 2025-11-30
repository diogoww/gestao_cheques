<?php
// fornecedores/create.php
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: ../auth/login.php'); exit; }
require_once __DIR__ . '/../database/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $cidade = $_POST['cidade'];

    $stmt = $conn->prepare("INSERT INTO fornecedores (nome, telefone, cidade) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $nome, $telefone, $cidade);
    $stmt->execute();
    header('Location: list.php');
    exit;
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Novo Fornecedor</title>
  <?php include __DIR__ . '/../includes/header.php'; ?>
</head>
<body>
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <div class="container mt-4">
        <h3>Novo Fornecedor</h3>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input class="form-control" name="nome" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Telefone</label>
                <input class="form-control" name="telefone">
            </div>
            <div class="mb-3">
                <label class="form-label">Cidade</label>
                <input class="form-control" name="cidade">
            </div>
                <div class="d-grid">
                <button class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    </body>
</html>
