<?php
session_start();
require 'includes/config.php';

if (!isset($_SESSION["username"])) {
  header("Location: login.php");
  exit;
}

$username = $_SESSION["username"];
$msg = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $char_name = trim($_POST["character_name"]);
  $gender = $_POST["gender"];
  $age = (int)$_POST["age"];

  if ($char_name && $gender && $age > 0) {
    $stmt = $conn->prepare("INSERT INTO characters (username, character_name, gender, age) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $char_name, $gender, $age]);
    $msg = "🎉 Karakter berhasil dibuat!";
  } else {
    $msg = "❌ Harap isi semua data dengan benar.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Buat Karakter - UCP</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen p-6">
  <div class="max-w-xl mx-auto bg-white/10 p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4 text-center">🧍‍♂️ Buat Karakter Baru</h2>

    <?php if ($msg): ?>
      <div class="mb-4 text-center font-semibold <?= strpos($msg, 'berhasil') ? 'text-green-400' : 'text-red-400' ?>">
        <?= $msg ?>
      </div>
    <?php endif; ?>

    <form method="POST">
      <label class="block mb-2">Nama Karakter:</label>
      <input type="text" name="character_name" required class="w-full p-2 mb-4 rounded bg-gray-800 border border-gray-600" />

      <label class="block mb-2">Jenis Kelamin:</label>
      <select name="gender" required class="w-full p-2 mb-4 rounded bg-gray-800 border border-gray-600">
        <option value="">Pilih...</option>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
      </select>

      <label class="block mb-2">Umur:</label>
      <input type="number" name="age" required min="1" class="w-full p-2 mb-4 rounded bg-gray-800 border border-gray-600" />

      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded transition">
        Simpan Karakter
      </button>
    </form>
  </div>
</body>
</html>
