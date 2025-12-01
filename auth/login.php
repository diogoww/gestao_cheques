<?php
session_start();
require_once __DIR__ . '/../database/connect.php';

$erro_login = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['username'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($usuario === '' || $senha === '') {
        $erro_login = "Preencha o usuário e a senha.";
    } else {
        $stsm = $conn->prepare("SELECT id, username, senha FROM usuarios WHERE username = ?");
        $stsm->bind_param('s', $usuario);
        $stsm->execute();
        $res = $stsm->get_result();

        if ($res && $res->num_rows === 1) {
            $user = $res->fetch_assoc();
            if (password_verify($senha, $user['senha'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['username'];
                header('Location: ../index.php');
                exit;
            } else {
                $erro_login = "Usuário ou senha incorretos.";
            }
        } else {
            $erro_login = "Usuário ou senha incorretos.";
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

    <style>
        body {
            background-color: #E8F5E9; /* verde pastel leve */
        }

        .login-container {
            height: 100vh;
        }

        .title-app {
            font-weight: 600;
            color: #2E7D32;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center login-container">

    <div class="w-100" style="max-width: 450px;">

        <h1 class="text-center title-app">
            Grupo Rocha <br>
            <small class="text-muted">Gerenciamento de Cheques</small>
        </h1>

        <div class="card p-4 shadow-sm">
            <h4 class="mb-3 text-center">Entrar</h4>

            <?php if ($erro_login): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erro_login) ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Usuário</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="senha" class="form-control" required>
                </div>

                <div class="d-grid mb-2">
                    <button class="btn btn-success">Entrar</button>
                </div>
            </form>

            <div class="text-center mt-2">
                <small>Ainda não tem conta?
                    <a href="register.php" style="color: #198754; text-decoration: none;">Registrar novo usuário</a>
                </small>
            </div>
        </div>

    </div>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
