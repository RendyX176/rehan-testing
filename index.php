<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Selamat Datang di SAMP UCP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-indigo-700 to-purple-800 min-h-screen text-white flex flex-col justify-center items-center relative overflow-hidden">

  <div class="absolute inset-0 bg-gradient-to-tr from-blue-900 to-transparent opacity-30 animate-pulse"></div>

  <div class="z-10 text-center px-6" data-aos="fade-up">
    <h1 class="text-5xl md:text-6xl font-extrabold mb-6">Welcome to <span class="text-yellow-300">SAMP UCP</span></h1>
    <p class="text-lg mb-8 max-w-xl mx-auto">Portal akun resmi untuk server GTA San Andreas Multiplayer kamu. Kelola akun, karakter, dan item dengan mudah.</p>
    <div class="flex justify-center gap-4">
      <a href="login.php" class="bg-yellow-400 hover:bg-yellow-300 text-black px-6 py-3 rounded-lg shadow transition duration-300 font-semibold">Login</a>
      <a href="register.php" class="bg-white hover:bg-gray-200 text-purple-700 px-6 py-3 rounded-lg shadow transition duration-300 font-semibold">Register</a>
    </div>
  </div>

  <footer class="absolute bottom-4 text-sm text-white/70 z-10">
    &copy; <?= date('Y') ?> SAMP UCP. All rights reserved.
  </footer>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
  <h1 live server h1></h1>
</body>
</html>
