<?php
session_start();
require 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $stmt = $conn->prepare("SELECT * FROM accounts WHERE username = ?");
  $stmt->execute([$username]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user["password"])) {
    $_SESSION["username"] = $user["username"];
    $_SESSION["is_admin"] = $user["is_admin"];
    header("Location: dashboard.php");
    exit;
  } else {
    $error = "Username atau password salah.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login - SAMP UCP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
</head>
<body class="bg-gradient-to-br from-slate-800 to-gray-900 text-white min-h-screen flex justify-center items-center">

  <div class="bg-white/5 backdrop-blur-sm p-8 rounded-2xl shadow-lg w-full max-w-md" data-aos="zoom-in">
    <h2 class="text-3xl font-bold text-center mb-6">Login ke UCP</h2>

    <?php if (isset($error)): ?>
      <div class="bg-red-600 text-white px-4 py-2 mb-4 rounded text-sm text-center">
        <?= $error ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-5">
      <div>
        <label class="block mb-1 text-sm">Username</label>
        <input type="text" name="username" required class="w-full px-4 py-2 rounded-lg bg-white/10 text-white border border-white/20 focus:outline-none focus:ring-2 focus:ring-yellow-400"/>
      </div>
      <div>
        <label class="block mb-1 text-sm">Password</label>
        <input type="password" name="password" required class="w-full px-4 py-2 rounded-lg bg-white/10 text-white border border-white/20 focus:outline-none focus:ring-2 focus:ring-yellow-400"/>
      </div>
      <button type="submit" class="w-full bg-yellow-400 text-black font-semibold py-2 rounded-lg hover:bg-yellow-300 transition duration-300">
        Login
      </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-300">
      Belum punya akun? <a href="register.php" class="text-yellow-400 hover:underline">Daftar sekarang</a>
    </p>
  </div>

  <script src=""></script>
  <script>AOS.init();</script>
</body>
</html>
