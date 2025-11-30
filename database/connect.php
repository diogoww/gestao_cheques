<?php
$conn = new mysqli("localhost", "root", "", "gestao_cheques", 3307);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>