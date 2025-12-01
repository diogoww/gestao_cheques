<?php
    if (!isset($_SESSION)) {
        session_start();
    }
?>

<nav class="navbar navbar-expand-lg bg-pastel navbar-light">
  <div class="container">
    <a class="navbar-brand">Cheque Master</a>
    <?php if (isset($_SESSION['user_id'])): ?>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-dark" href="/gestao_cheques/cheques/list.php">Cheques</a>
        <a class="btn btn-outline-dark" href="/gestao_cheques/fornecedores/list.php">Fornecedores</a>
        <a class="btn btn-voltar" href="javascript:history.back()">Voltar uma Página</a>
        <a class="btn btn-voltar" href="/gestao_cheques/index.php">Voltar ao Início</a>
        <a class="btn btn-outline-dark btn-sair" href="/gestao_cheques/auth/logout.php">Sair</a>
      </div>
    <?php endif; ?>
  </div>
</nav>