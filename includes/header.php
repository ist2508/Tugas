<?php
session_start();
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
    <title><?php echo $page_title ?? 'Sistem Pendaftaran SD'; ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
    <h1>Sistem Pendaftaran Sekolah Dasar</h1>
    <nav>
        <ul>
            <li><a href="beranda.php">Beranda</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>
<main>