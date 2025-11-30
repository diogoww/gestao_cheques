<?php
// fornecedores/edit.php
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: ../auth/login.php'); exit; }
require_once __DIR__ . '/../database/connect.php';

$id = intval($_GET['id'] ?? 0);
$res = $conn->query("SELECT * FROM fornecedores WHERE id = $id");
if (!$res || $res->num_rows === 0) { header('Location: list.php'); exit; }
$fornecedor = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $cidade = $_POST['cidade'];

    $stmt = $conn->prepare("UPDATE fornecedores SET nome = ?, telefone = ?, cidade = ? WHERE id = ?");
    $stmt->bind_param('sssi', $nome, $telefone, $cidade, $id);
    $stmt->execute();
    header('Location: list.php');
    exit;
}
?>

<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Editar Fornecedor</title>
  <?php include __DIR__ . '/../includes/header.php'; ?>
</head>
<body>
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <div class="container mt-4">
        <h3>Editar Fornecedor</h3>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input class="form-control" name="nome" value="<?= htmlspecialchars($fornecedor['nome']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Telefone</label>
                <input class="form-control" name="telefone" value="<?= htmlspecialchars($fornecedor['telefone']) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Cidade</label>
                <input class="form-control" name="cidade" value="<?= htmlspecialchars($fornecedor['cidade']) ?>">
            </div>
                <div class="d-grid">
                <button class="btn btn-primary">Salvar Alterações</button>
            </div>
        </form>
    </div>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
