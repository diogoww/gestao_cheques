<?php
// cheques/create.php
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: ../auth/login.php'); exit; }
require_once __DIR__ . '/../database/connect.php';

$fornecedores = $conn->query("SELECT id, nome FROM fornecedores ORDER BY nome");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['numero_cheque'];
    $valor = str_replace(',', '.', $_POST['valor']);
    $data_emissao = $_POST['data_emissao'];
    $data_vencimento = $_POST['data_vencimento'];
    $fornecedor_id = empty($_POST['fornecedor_id']) ? null : intval($_POST['fornecedor_id']);
    $observacoes = $_POST['observacoes'];

    $stmt = $conn->prepare("INSERT INTO cheques (numero_cheque, valor, data_emissao, data_vencimento, observacao, fornecedor_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sdsssi', $numero, $valor, $data_emissao, $data_vencimento, $observacoes, $fornecedor_id);
    $stmt->execute();
    header('Location: list.php');
    exit;
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Novo Cheque</title>
  <?php include __DIR__ . '/../includes/header.php'; ?>
</head>
<body>
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <div class="container mt-4">
        <h3>Novo Cheque</h3>
        <form method="post">
            <div class="mb-3">
            <label>Número do cheque</label>
            <input name="numero_cheque" class="form-control" required>
            </div>
            <div class="row g-2">
                <div class="col-md-4 mb-3">
                    <label>Data emissão</label>
                    <input type="date" name="data_emissao" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Data vencimento</label>
                    <input type="date" name="data_vencimento" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Valor</label>
                    <input type="text" name="valor" class="form-control" required placeholder="Ex: 1500.00">
                </div>
            </div>

            <div class="mb-3">
                <label>Fornecedor</label>
                <select name="fornecedor_id" class="form-select">
                    <option value="">-- sem vínculo --</option>
                    <?php while ($f = $fornecedores->fetch_assoc()): ?>
                    <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['nome']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Observações</label>
                <textarea name="observacoes" class="form-control"></textarea>
            </div>

            <div class="d-grid">
                <button class="btn btn-primary">Salvar Cheque</button>
            </div>
        </form>
    </div>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
