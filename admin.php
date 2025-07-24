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

if (!$user || $user["is_admin"] != 1) {
  die("Akses ditolak.");
}

// Tambah item baru
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nama_barang"])) {
  $nama = $_POST["nama_barang"];
  $harga = $_POST["harga"];
  $stok = $_POST["stok"];

  $stmt = $conn->prepare("INSERT INTO store (nama_barang, harga, stok) VALUES (?, ?, ?)");
  $stmt->execute([$nama, $harga, $stok]);

  header("Location: admin.php?success=1");
  exit;
}

$items = $conn->query("SELECT * FROM store ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Panel - SAMP UCP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
</head>
<body class="bg-gradient-to-br from-gray-950 to-gray-900 text-white min-h-screen">

  <div class="max-w-4xl mx-auto py-10 px-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-yellow-300" data-aos="fade-down">Admin Panel</h1>

    <!-- Form Tambah Item -->
    <div class="bg-white/10 p-6 rounded-lg mb-8" data-aos="fade-up">
      <h2 class="text-xl font-semibold mb-4">Tambah Barang</h2>
      <form method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <input type="text" name="nama_barang" placeholder="Nama Barang" required class="p-2 rounded bg-white/20 text-white" />
        <input type="number" name="harga" placeholder="Harga" required class="p-2 rounded bg-white/20 text-white" />
        <input type="number" name="stok" placeholder="Stok" required class="p-2 rounded bg-white/20 text-white" />
        <div class="md:col-span-3">
          <button type="submit" class="bg-indigo-500 hover:bg-indigo-400 text-white font-semibold px-6 py-2 rounded transition">Tambah Barang</button>
        </div>
      </form>
    </div>

    <!-- List Barang -->
    <div class="bg-white/10 p-6 rounded-lg" data-aos="fade-up" data-aos-delay="100">
      <h2 class="text-xl font-semibold mb-4">Daftar Barang</h2>
      <table class="w-full text-left text-sm border-collapse">
        <thead>
          <tr class="text-indigo-300 border-b border-white/10">
            <th class="py-2">Nama</th>
            <th>Harga</th>
            <th>Stok</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($items as $item): ?>
          <tr class="border-b border-white/5">
            <td class="py-2"><?= htmlspecialchars($item["nama_barang"]) ?></td>
            <td>Rp <?= number_format($item["harga"], 0, ',', '.') ?></td>
            <td><?= $item["stok"] ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="text-center mt-6">
      <a href="dashboard.php" class="text-indigo-300 hover:underline">Kembali ke Dashboard</a>
    </div>
  </div>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>AOS.init();</script>
</body>
</html>
