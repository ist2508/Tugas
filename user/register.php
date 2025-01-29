<?php
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Query untuk menyimpan data pengguna
    $query = "INSERT INTO users (username, password, role) VALUES (?, ?, 'user')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $username, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Pendaftaran berhasil! Silakan login.'); window.location = 'login.php';</script>";
    } else {
        echo "<script>alert('Pendaftaran gagal. Username mungkin sudah digunakan.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <form method="POST">
        <h1>Register</h1>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Daftar</button>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </form>
</body>
</html>
