<?php
session_start();
require 'includes/config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

// Ambil data user
$stmt = $conn->prepare("SELECT saldo FROM accounts WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

// Ambil data item
$items = $conn->query("SELECT * FROM store_items ORDER BY id ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Toko - SAMP UCP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-gray-900 to-black text-white min-h-screen">

<!-- Navbar -->
<nav class="bg-white/10 backdrop-blur px-6 py-4 flex justify-between items-center sticky top-0 z-50 shadow">
  <div class="text-xl font-bold text-yellow-400">SAMP UCP</div>
  <div class="space-x-4">
    <a href="dashboard.php" class="hover:underline">Dashboard</a>
    <a href="store.php" class="text-yellow-400 underline">Toko</a>
    <a href="topup.php" class="hover:underline">Isi Saldo</a>
    <a href="logout.php" class="hover:underline text-red-400">Logout</a>
  </div>
</nav>

<div class="max-w-6xl mx-auto py-10 px-6" data-aos="fade-up">
  <div class="mb-8 flex justify-between items-center">
    <h1 class="text-3xl font-bold">Toko Item</h1>
    <div class="bg-yellow-500 text-black px-4 py-2 rounded-full font-semibold shadow">
      Saldo: Rp <?= number_format($user['saldo'], 0, ',', '.') ?>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <?php foreach ($items as $item): ?>
      <div class="bg-white/10 p-5 rounded-xl shadow hover:scale-105 transition duration-300" data-aos="fade-up">
        <h2 class="text-xl font-bold text-yellow-300 mb-2"><?= htmlspecialchars($item['nama']) ?></h2>
        <p class="mb-1 text-sm">Harga: <span class="text-green-400">Rp <?= number_format($item['harga'], 0, ',', '.') ?></span></p>
        <p class="mb-3 text-sm">Stok: <span class="<?= $item['stok'] > 0 ? 'text-white' : 'text-red-400' ?>">
          <?= $item['stok'] > 0 ? $item['stok'] : 'Habis' ?>
        </span></p>

        <form action="buy.php" method="POST">
          <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
          <button type="submit"
                  <?= $item['stok'] <= 0 ? 'disabled' : '' ?>
                  class="w-full py-2 mt-2 rounded font-semibold transition
                         ' . ($item['stok'] > 0
                         ? 'bg-yellow-400 hover:bg-yellow-300 text-black'
                         : 'bg-gray-500 text-gray-300 cursor-not-allowed') . '">
            <?= $item['stok'] > 0 ? 'Beli' : 'Stok Habis' ?>
          </button>
        </form>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
