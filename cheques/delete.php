<?php
// cheques/delete.php
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: ../auth/login.php'); exit; }
require_once __DIR__ . '/../database/connect.php';

$id = intval($_GET['id'] ?? 0);
if ($id) {
    $stmt = $conn->prepare("DELETE FROM cheques WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
}
header('Location: list.php');
exit;
