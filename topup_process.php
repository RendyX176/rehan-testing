<?php
session_start();
require 'includes/config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$amount = intval($_POST['amount']);
$method = $_POST['method'];

if ($amount <= 0 || empty($method)) {
    die("Jumlah atau metode tidak valid.");
}

$stmt = $conn->prepare("INSERT INTO topup_requests (username, amount, method, status) VALUES (?, ?, ?, 'pending')");
$stmt->execute([$username, $amount, $method]);

header("Location: topup.php?success=1");
exit;
?>
