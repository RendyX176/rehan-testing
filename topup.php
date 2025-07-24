<?php
session_start();
require 'includes/config.php';

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Isi Saldo - UCP</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <style>
    body {
      background: #0f172a;
      color: #e2e8f0;
      font-family: 'Segoe UI', sans-serif;
    }
    .neon-btn {
      background: linear-gradient(90deg, #4f46e5, #06b6d4);
      color: white;
      border: none;
      transition: all 0.3s ease-in-out;
      box-shadow: 0 0 10px #06b6d4;
    }
    .neon-btn:hover {
      box-shadow: 0 0 20px #06b6d4;
      transform: scale(1.05);
    }
    .glass {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      padding: 20px;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
    input:focus {
      outline: none;
      border-color: #06b6d4;
    }
  </style>
</head>
<body class="p-6">
    <?php if (isset($_GET['success'])): ?>
  <div id="notif" class="fixed top-4 right-4 bg-blue-600 text-white px-5 py-3 rounded-lg shadow-lg z-50 animate-fade">
    ✅ Permintaan topup Anda telah dikirim.<br>
    Mohon tunggu persetujuan dari admin sebelum saldo masuk ke akun Anda.
  </div>
  <script>
    setTimeout(() => {
      const notif = document.getElementById('notif');
      if (notif) notif.remove();
    }, 5000); // hilang setelah 5 detik
  </script>
  <style>
    @keyframes fade {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade {
      animation: fade 0.3s ease-out;
    }
  </style>
<?php endif; ?>

  <div class="max-w-2xl mx-auto glass" data-aos="zoom-in">
    <h2 class="text-2xl font-bold mb-4 text-center">💸 Isi Saldo</h2>

    <form action="topup_process.php" method="POST">
      <label class="block mb-2 text-sm">Jumlah:</label>
      <div class="grid grid-cols-3 gap-3 mb-4">
        <?php
        $options = [1000, 5000, 10000, 20000, 50000, 100000];
        foreach ($options as $val) {
          echo "<button type='button' class='neon-btn rounded py-2' onclick='setAmount($val)'>Rp" . number_format($val, 0, ',', '.') . "</button>";
        }
        ?>
      </div>
      <input type="number" name="amount" id="amount" class="w-full p-2 mb-4 rounded bg-gray-800 border border-gray-600" placeholder="Atau masukkan jumlah manual" required />

      <label class="block mb-2 text-sm">Metode Pembayaran:</label>
      <div class="flex gap-4 mb-4">
        <label class="flex items-center gap-2 cursor-pointer">
          <input type="radio" name="method" value="Dana" onclick="setNumber('Dana')" required />
          <span>Dana</span>
        </label>
        <label class="flex items-center gap-2 cursor-pointer">
          <input type="radio" name="method" value="GoPay" onclick="setNumber('GoPay')" />
          <span>GoPay</span>
        </label>
      </div>

      <div id="number" class="mb-4 text-sm text-blue-300"></div>

      <button type="submit" class="neon-btn w-full py-2 rounded mt-4">KIRIM PERMINTAAN</button>
    </form>
  </div>

  <script>
    function setAmount(val) {
      document.getElementById('amount').value = val;
    }

    function setNumber(method) {
      const numberBox = document.getElementById('number');
      if (method === 'Dana') {
        numberBox.innerHTML = '📱 Kirim ke: <strong>0896-1234-5678</strong>';
      } else if (method === 'GoPay') {
        numberBox.innerHTML = '📱 Kirim ke: <strong>0857-9876-4321</strong>';
      }
    }
  </script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>AOS.init();</script>
</body>
</html>
