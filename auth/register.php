<?php
session_start();
require_once __DIR__ . '/../database/connect.php';

$erro_registro = '';
$sucesso_registro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_usuario = trim($_POST['novo_username'] ?? '');
    $nova_senha = $_POST['nova_senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    if ($novo_usuario === '' || $nova_senha === '' || $confirmar_senha === '') {
        $erro_registro = "Preencha todos os campos para registro.";
    } elseif ($nova_senha !== $confirmar_senha) {
        $erro_registro = "As senhas não conferem.";
    } else {
        // verifica se usuário já existe
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE username = ?");
        $stmt->bind_param('s', $novo_usuario);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res && $res->num_rows > 0) {
            $erro_registro = "Já existe um usuário com este nome.";
        } else {
            // cria usuário com senha hasheada
            $hash = password_hash($nova_senha, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO usuarios (username, senha) VALUES (?, ?)");
            $stmt->bind_param('ss', $novo_usuario, $hash);

            if ($stmt->execute()) {
                $sucesso_registro = "Usuário registrado com sucesso! Agora você já pode fazer login.";
            } else {
                $erro_registro = "Erro ao registrar usuário. Tente novamente.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar - Cheque Master</title>
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
            <h4 class="mb-3 text-center">Registrar novo usuário</h4>

            <?php if ($sucesso_registro): ?>
                <div class="alert alert-success"><?= htmlspecialchars($sucesso_registro) ?></div>
            <?php endif; ?>

            <?php if ($erro_registro): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erro_registro) ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Usuário</label>
                    <input type="text" name="novo_username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="nova_senha" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirmar senha</label>
                    <input type="password" name="confirmar_senha" class="form-control" required>
                </div>

                <div class="d-grid mb-2">
                    <button class="btn btn-success">Registrar</button>
                </div>
            </form>

            <div class="text-center mt-2">
                <small>Já tem conta?
                    <a href="login.php" style="color: #198754; text-decoration: none;">Ir para o login</a>
                </small>
            </div>
        </div>

    </div>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>


