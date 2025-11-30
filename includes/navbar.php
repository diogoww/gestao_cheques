<?php
    if (!isset($_SESSION)) {
        session_start();
    }
?>

<nav class="navbar navbar-expand-lg bg-pastel navbar-light">
  <div class="container">
    <a class="navbar-brand" href="/index.php">Gestão Cheques</a>
    <?php if (isset($_SESSION['user_id'])): ?>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-dark" href="/cheques/list.php">Cheques</a>
        <a class="btn btn-outline-dark" href="/fornecedores/list.php">Fornecedores</a>
        <a class="btn btn-danger" href="/auth/logout.php">Sair</a>
      </div>
    <?php endif; ?>
  </div>
</nav>