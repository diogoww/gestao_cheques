<?php
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="/gestao_cheques/style.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

    body {
        background-color: #E8F5E9 !important;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .menu-card {
        background-color: #1B5E20 !important; /* Verde escuro */
        color: white !important;
        border: none;
        transition: 0.25s ease;
        cursor: pointer;
        border-radius: 15px;
    }

    .menu-card:hover {
        transform: scale(1.05);
        background-color: #144A18 !important; /* Tom mais escuro no hover */
        box-shadow: 0 4px 15px rgba(0,0,0,0.25);
    }

    .menu-card h3 {
        color: white !important;
        font-weight: 600;
    }

    .navbar {
        background-color: #1B5E20 !important; /* Verde escuro */
    }

    .navbar .navbar-brand {
        color: white !important;
        font-weight: 600;
    }

    .navbar .btn {
    background-color: #2E7D32 !important; /* Verde médio */
    color: white !important;
    border: none !important;
    }

    /* Hover dos botões verdes */
    .navbar .btn:hover {
        background-color: #1B5E20 !important; /* Verde escuro */
        transform: scale(1.05);
    }

    /* Ajuste especial para o botão SAIR */
    .navbar .btn-sair {
        background-color: #c62828 !important; /* Vermelho */
        color: white !important;
    }

    .navbar .btn-sair:hover {
        background-color: #8e0000 !important; /* Vermelho mais escuro */
        transform: scale(1.05);
    }

    /* Botão voltar - deve vir depois para sobrescrever .navbar .btn */
    .navbar .btn-voltar {
        background-color: #f7a600 !important; /* laranja forte */
        color: white !important;
        border: none !important;
    }
    
    .navbar .btn-voltar:hover {
        background-color: #e69400 !important; /* laranja mais escuro no hover */
        transform: scale(1.05);
    }
</style>