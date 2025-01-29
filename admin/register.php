<?php
session_start();
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = "INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $username, $password);
    if ($stmt->execute()) {
        header('Location: login.php');
    } else {
        $error = 'Registrasi gagal.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Admin</title>
    <link rel="stylesheet" href="../css/register.css">
</head>
<script src="js/script.js"></script>
<body>
    <form method="POST">
        <h1>Register Admin</h1>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
        <?php if (!empty($error)) echo "<p>$error</p>"; ?>
    </form>
</body>
</html>