<?php
session_start();
require 'includes/config.php';

if (!isset($_SESSION['username']) || $_SESSION['is_admin'] != 1) {
  header("Location: login.php");
  exit;
}

if (isset($_GET['acc'])) {
  $topup_id = intval($_GET['acc']);

  // Ambil data topup
  $stmt = $conn->prepare("SELECT * FROM topup WHERE id = ? AND status = 'Pending'");
  $stmt->execute([$topup_id]);
  $data = $stmt->fetch();

  if ($data) {
    // Tambah saldo user
    $stmt = $conn->prepare("UPDATE accounts SET saldo = saldo + ? WHERE username = ?");
    $stmt->execute([$data['amount'], $data['username']]);

    // Update status topup
    $stmt = $conn->prepare("UPDATE topup SET status = 'Approved' WHERE id = ?");
    $stmt->execute([$topup_id]);

    header("Location: admin_topup.php?done=1");
    exit;
  }
}

// Ambil semua topup pending
$stmt = $conn->query("SELECT * FROM topup WHERE status = 'Pending' ORDER BY tanggal DESC");
$topups = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin - ACC Topup</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white p-6">
  <div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">📥 Permintaan Topup</h1>

    <?php if (isset($_GET['done'])): ?>
      <div class="bg-green-600 px-4 py-2 rounded mb-4">✅ Berhasil meng-ACC topup.</div>
    <?php endif; ?>

    <?php if (count($topups) === 0): ?>
      <div class="bg-gray-700 p-4 rounded">Tidak ada permintaan topup pending.</div>
    <?php else: ?>
      <table class="w-full table-auto bg-gray-800 rounded overflow-hidden">
        <thead>
          <tr class="bg-gray-700">
            <th class="px-4 py-2">Username</th>
            <th class="px-4 py-2">Jumlah</th>
            <th class="px-4 py-2">Metode</th>
            <th class="px-4 py-2">Tanggal</th>
            <th class="px-4 py-2">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($topups as $row): ?>
            <tr class="border-t border-gray-600">
              <td class="px-4 py-2"><?= htmlspecialchars($row['username']) ?></td>
              <td class="px-4 py-2">Rp<?= number_format($row['amount'], 0, ',', '.') ?></td>
              <td class="px-4 py-2"><?= $row['method'] ?></td>
              <td class="px-4 py-2"><?= $row['tanggal'] ?></td>
              <td class="px-4 py-2">
                <a href="admin_topup.php?acc=<?= $row['id'] ?>" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">ACC</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</body>
</html>
