<?php
session_start();

// Pastikan pengguna sudah login dan telah berhasil mendaftar
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil</title>
    <link rel="stylesheet" href="../css/success.css">
</head>
<body>
    <div class="container">
        <h1>Pendaftaran Berhasil!</h1>
        <p>Terima kasih, pendaftaran Anda telah berhasil. Anda akan menerima informasi lebih lanjut mengenai proses selanjutnya melalui email atau melalui situs ini.</p>
        <p><a href="beranda.php">Kembali ke halaman utama</a></p>
    </div>
</body>
</html>
