<?php
require 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

  // Cek apakah username sudah digunakan
  $stmt = $conn->prepare("SELECT * FROM accounts WHERE username = ?");
  $stmt->execute([$username]);

  if ($stmt->rowCount() > 0) {
    $error = "Username sudah terdaftar.";
  } else {
    $stmt = $conn->prepare("INSERT INTO accounts (username, password, is_admin, saldo) VALUES (?, ?, 0, 0)");
    $stmt->execute([$username, $password]);
    header("Location: login.php");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Register - SAMP UCP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
</head>
<body class="bg-gradient-to-br from-gray-900 to-gray-800 text-white min-h-screen flex justify-center items-center">

  <div class="bg-white/5 backdrop-blur-sm p-8 rounded-2xl shadow-lg w-full max-w-md" data-aos="flip-up">
    <h2 class="text-3xl font-bold text-center mb-6">Buat Akun Baru</h2>

    <?php if (isset($error)): ?>
      <div class="bg-red-600 text-white px-4 py-2 mb-4 rounded text-sm text-center">
        <?= $error ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-5">
      <div>
        <label class="block mb-1 text-sm">Username</label>
        <input type="text" name="username" required class="w-full px-4 py-2 rounded-lg bg-white/10 text-white border border-white/20 focus:outline-none focus:ring-2 focus:ring-indigo-400"/>
      </div>
      <div>
        <label class="block mb-1 text-sm">Password</label>
        <input type="password" name="password" required class="w-full px-4 py-2 rounded-lg bg-white/10 text-white border border-white/20 focus:outline-none focus:ring-2 focus:ring-indigo-400"/>
      </div>
      <button type="submit" class="w-full bg-indigo-500 text-white font-semibold py-2 rounded-lg hover:bg-indigo-400 transition duration-300">
        Daftar
      </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-300">
      Sudah punya akun? <a href="login.php" class="text-indigo-300 hover:underline">Masuk di sini</a>
    </p>
  </div>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>AOS.init();</script>
</body>
</html>
