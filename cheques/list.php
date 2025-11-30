<?php
// cheques/list.php
session_start();
if (!isset($_SESSION['user_id'])) { 
    header('Location: ../auth/login.php'); exit; 
}
require_once __DIR__ . '/../database/connect.php';

// filtros simples via GET (opcional)
$where = '1=1';
$params = [];
$types = '';

if (!empty($_GET['fornecedor'])) { $where .= ' AND c.fornecedor_id = ?'; $params[] = $_GET['fornecedor']; $types .= 'i'; }
if (!empty($_GET['numero'])) { $where .= ' AND c.numero_cheque LIKE ?'; $params[] = '%' . $_GET['numero'] . '%'; $types .= 's'; }
if (!empty($_GET['status']) && $_GET['status'] === 'vencidos') { $where .= ' AND c.data_vencimento < CURDATE() AND c.data_pagamento IS NULL'; }

$sql = "SELECT c.*, f.nome AS fornecedor
        FROM cheques c
        LEFT JOIN fornecedores f ON f.id = c.fornecedor_id
        WHERE $where
        ORDER BY c.data_vencimento ASC, c.id DESC";

$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$res = $stmt->get_result();
$cheques = $res->fetch_all(MYSQLI_ASSOC);

$fornecedores = $conn->query("SELECT id, nome FROM fornecedores ORDER BY nome");
?>

<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Cheques</title>
  <?php include __DIR__ . '/../includes/header.php'; ?>
</head>
<body>
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Cheques</h3>
            <a class="btn btn-primary" href="create.php">Novo Cheque</a>
        </div>

        <form class="card p-3 mb-3" method="get">
            <div class="row g-2">
                <div class="col-md-3">
                    <input class="form-control" name="numero" placeholder="Número" value="<?= htmlspecialchars($_GET['numero'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <select name="fornecedor" class="form-select">
                    <option value="">Todos fornecedores</option>
                    <?php foreach ($fornecedores as $f): ?>
                        <option value="<?= $f['id'] ?>" <?= (isset($_GET['fornecedor']) && $_GET['fornecedor']==$f['id']) ? 'selected' : '' ?>><?= htmlspecialchars($f['nome']) ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary">Filtrar</button>
                </div>
                <div class="col-md-4 text-end">
                    <a class="btn btn-outline-success" href="list.php?status=vencidos">Ver vencidos</a>
                </div>
            </div>
        </form>

        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Número</th>
                    <th>Fornecedor</th>
                    <th>Emissão</th>
                    <th>Vencimento</th>
                    <th>Valor</th>
                    <th>Pago em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($cheques) === 0): ?>
                    <tr><td colspan="8" class="text-center">Nenhum cheque encontrado</td></tr>
                <?php endif; ?>
                <?php foreach ($cheques as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= htmlspecialchars($c['numero_cheque']) ?></td>
                    <td><?= htmlspecialchars($c['fornecedor']) ?></td>
                    <td><?= $c['data_emissao'] ?></td>
                    <td><?= $c['data_vencimento'] ?></td>
                    <td>R$ <?= number_format($c['valor'],2,',','.') ?></td>
                    <td><?= $c['data_pagamento'] ?? '-' ?></td>
                    <td>
                    <a class="btn btn-sm btn-warning" href="edit.php?id=<?= $c['id'] ?>">Editar</a>
                    <a class="btn btn-sm btn-danger" href="delete.php?id=<?= $c['id'] ?>" onclick="return confirm('Remover cheque?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
