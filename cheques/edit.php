<?php
// cheques/edit.php
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: ../auth/login.php'); exit; }
require_once __DIR__ . '/../database/connect.php';

$id = intval($_GET['id'] ?? 0);
$res = $conn->query("SELECT * FROM cheques WHERE id = $id");
if (!$res || $res->num_rows === 0) { header('Location: list.php'); exit; }
$cheque = $res->fetch_assoc();
$fornecedores = $conn->query("SELECT id, nome FROM fornecedores ORDER BY nome");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['numero_cheque'];
    $valor = str_replace(',', '.', $_POST['valor']);
    $data_emissao = $_POST['data_emissao'];
    $data_vencimento = $_POST['data_vencimento'];
    $data_pagamento = empty($_POST['data_pagamento']) ? null : $_POST['data_pagamento'];
    $fornecedor_id = empty($_POST['fornecedor_id']) ? null : intval($_POST['fornecedor_id']);
    $observacoes = $_POST['observacao'];

    $stmt = $conn->prepare("UPDATE cheques SET numero_cheque=?, valor=?, data_emissao=?, data_vencimento=?, data_pagamento=?, observacao=?, fornecedor_id=? WHERE id=?");
    $stmt->bind_param('sdsssisi', $numero, $valor, $data_emissao, $data_vencimento, $data_pagamento, $observacoes, $fornecedor_id, $id);
    $stmt->execute();
    header('Location: list.php');
    exit;
}
?>

<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Editar Cheque</title>
  <?php include __DIR__ . '/../includes/header.php'; ?>
</head>
<body>
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <div class="container mt-4">
        <h3>Editar Cheque</h3>
        <form method="post">
            <div class="mb-3">
            <label>Número do cheque</label>
            <input name="numero_cheque" class="form-control" required value="<?= htmlspecialchars($cheque['numero_cheque']) ?>">
            </div>

            <div class="row g-2">
                <div class="col-md-4 mb-3">
                    <label>Data emissão</label>
                    <input type="date" name="data_emissao" class="form-control" value="<?= $cheque['data_emissao'] ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Data vencimento</label>
                    <input type="date" name="data_vencimento" class="form-control" value="<?= $cheque['data_vencimento'] ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Valor</label>
                    <input type="text" name="valor" class="form-control" value="<?= number_format($cheque['valor'],2,'.','') ?>">
                </div>
            </div>

            <div class="mb-3">
                <label>Fornecedor</label>
                <select name="fornecedor_id" class="form-select">
                    <option value="">-- sem vínculo --</option>
                    <?php while ($f = $fornecedores->fetch_assoc()): ?>
                    <option value="<?= $f['id'] ?>" <?= ($f['id'] == $cheque['fornecedor_id']) ? 'selected' : '' ?>><?= htmlspecialchars($f['nome']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Observações</label>
                <textarea name="observacoes" class="form-control"><?= htmlspecialchars($cheque['observacoes']) ?></textarea>
            </div>

            <div class="mb-3">
                <label>Data pagamento (preencher quando compensado)</label>
                <input type="date" name="data_pagamento" value="<?= $cheque['data_pagamento'] ?>" class="form-control">
            </div>

            <div class="d-grid">
                <button class="btn btn-primary">Salvar Alterações</button>
            </div>
        </form>
    </div>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
