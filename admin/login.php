<?php
session_start();
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ? AND role = 'admin' LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin_id'] = $user['id'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'Password salah.';
        }
    } else {
        $error = 'Username tidak ditemukan.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="../css/loginadmin.css">
</head>
<script src="js/script.js"></script>
<body>
    <form method="POST">
        <h1>Login Admin</h1>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <?php if (!empty($error)) echo "<p>$error</p>"; ?>
    </form>
</body>
</html>