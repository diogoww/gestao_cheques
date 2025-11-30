<?php
$conn = new mysqli("localhost", "root", "", "gestao_cheques");

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>