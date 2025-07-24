<?php
session_start();
require 'includes/config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$item_id = $_POST['item_id'] ?? 0;

// Ambil data user
$stmt = $conn->prepare("SELECT saldo FROM accounts WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

// Ambil data item
$stmt = $conn->prepare("SELECT * FROM store_items WHERE id = ?");
$stmt->execute([$item_id]);
$item = $stmt->fetch();

if (!$item) {
    $_SESSION['error'] = "Item tidak ditemukan.";
    header("Location: store.php");
    exit;
}

if ($item['stok'] <= 0) {
    $_SESSION['error'] = "Stok barang sudah habis.";
    header("Location: store.php");
    exit;
}

if ($user['saldo'] < $item['harga']) {
    $_SESSION['error'] = "Saldo tidak cukup.";
    header("Location: store.php");
    exit;
}

// Kurangi saldo user
$stmt = $conn->prepare("UPDATE accounts SET saldo = saldo - ? WHERE username = ?");
$stmt->execute([$item['harga'], $username]);

// Kurangi stok barang
$stmt = $conn->prepare("UPDATE store_items SET stok = stok - 1 WHERE id = ?");
$stmt->execute([$item_id]);

// Simpan ke riwayat pembelian
$stmt = $conn->prepare("INSERT INTO pembelian (username, item_id, tanggal) VALUES (?, ?, NOW())");
$stmt->execute([$username, $item_id]);

$_SESSION['success'] = "Pembelian berhasil: {$item['nama']}";
header("Location: store.php");
exit;
?>
