<?php
session_start();
require 'includes/config.php';

if (!isset($_SESSION["username"])) {
  header("Location: login.php");
  exit;
}

$username = $_SESSION["username"];
$stmt = $conn->prepare("SELECT * FROM accounts WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();
$stmtChar = $conn->prepare("SELECT * FROM characters WHERE username = ?");
$stmtChar->execute([$username]);
$characters = $stmtChar->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard - SAMP UCP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
</head>
<body class="bg-gradient-to-br from-gray-900 to-black text-white min-h-screen">

  <!-- Navbar -->
  <nav class="bg-white/10 backdrop-blur sticky top-0 z-50 px-6 py-4 flex justify-between items-center shadow">
    <div class="text-xl font-bold text-yellow-400">SAMP UCP</div>
    <div class="space-x-4">
    <div class="space-x-4 flex items-center">
    <a href="dashboard.php" class="hover:underline">Dashboard</a>
    <a href="store.php" class="hover:underline">Toko</a>
    <a href="create_character.php" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded transition">
        Buat Karakter
    </a>

    <?php if ($user['is_admin']): ?>
        <a href="admin_topup.php" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded transition">
        ACC TopUp
        </a>
    <?php endif; ?>

    <a href="logout.php" class="hover:underline text-red-400">Logout</a>
    </div>


  <!-- Konten -->
  <div class="max-w-4xl mx-auto py-12 px-6" data-aos="fade-up">
        <h2 class="text-2xl font-semibold mt-12 mb-4">Karakter Kamu</h2>

    <?php if (count($characters) > 0): ?>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php foreach ($characters as $char): ?>
          <div class="bg-white/10 p-4 rounded-xl shadow hover:scale-105 transition" data-aos="fade-up">
            <h3 class="text-xl font-bold mb-1"><?= htmlspecialchars($char['character_name']) ?></h3>
            <p class="text-sm text-gray-300">Jenis Kelamin: <?= $char['gender'] ?></p>
            <p class="text-sm text-gray-300">Umur: <?= $char['age'] ?></p>
            <p class="text-sm text-gray-400">Dibuat: <?= date("d M Y H:i", strtotime($char['created_at'])) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="text-gray-400">Belum ada karakter. Silakan buat karakter dulu.</p>
    <?php endif; ?>

    <h1 class="text-4xl font-bold mb-4">Halo, <?= htmlspecialchars($user["username"]) ?> 👋</h1>
    <p class="text-lg mb-6">Selamat datang di panel akun SAMP kamu.</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white/10 p-6 rounded-xl shadow hover:scale-105 transition" data-aos="fade-up" data-aos-delay="100">
        <h2 class="text-xl font-semibold mb-2">Username</h2>
        <p class="text-yellow-300"><?= htmlspecialchars($user["username"]) ?></p>
      </div>
      <div class="bg-white/10 p-6 rounded-xl shadow hover:scale-105 transition" data-aos="fade-up" data-aos-delay="200">
        <h2 class="text-xl font-semibold mb-2">Saldo</h2>
        <p class="text-green-300">Rp <?= number_format($user["saldo"], 0, ',', '.') ?></p>
      </div>
      <div class="bg-white/10 p-6 rounded-xl shadow hover:scale-105 transition" data-aos="fade-up" data-aos-delay="300">
        <h2 class="text-xl font-semibold mb-2">Status</h2>
        <p class="<?= $user['is_admin'] ? 'text-blue-400' : 'text-white' ?>">
          <?= $user["is_admin"] ? "Administrator" : "User Biasa" ?>
        </p>
      </div>
    </div>
  </div>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>AOS.init();</script>
</body>
</html>
