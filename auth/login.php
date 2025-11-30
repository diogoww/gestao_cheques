<?php
session_start();
require_once __DIR__ . '/../database/connect.php';

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    // CORREÇÃO: pegar "usuario"
    $usuario = trim($_POST['usuario'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($usuario === '' || $senha === ''){
        $erro = "Preencha com usuário e senha.";
    } else {

        $stsm = $conn->prepare("SELECT id, username, senha FROM usuarios WHERE username = ?");
        $stsm->bind_param('s', $usuario);
        $stsm->execute();
        $res = $stsm->get_result();

        if ($res && $res->num_rows === 1){
            $user = $res->fetch_assoc();

            if (password_verify($senha, $user['senha'])) {

                $_SESSION['user_id'] = $user['id'];

                // CORREÇÃO: salvar o campo correto
                $_SESSION['user_name'] = $user['username'];

                header('Location: ../index.php');
                exit;
            } else {
                $erro = "Usuário ou senha incorretos.";
            }
        } else {
            $erro = "Usuário ou senha incorretos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cheque Master</title>
    <?php include __DIR__ . '/../includes/header.php'; ?>
</head>
<body>
    <div class="col-md-5">
      <div class="card p-4 shadow-sm">
        <h4 class="mb-3">Entrar</h4>
        <?php if ($erro): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Usuário</label>
            <input type="text" name="usuario" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Senha</label>
            <input type="password" name="senha" class="form-control" required>
          </div>
          <div class="d-grid">
            <button class="btn btn-primary">Entrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>