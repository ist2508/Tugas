<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

include '../config/database.php';

// Pastikan ID pengumuman valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_pengumuman = $_GET['id'];

    // Query untuk menghapus pengumuman
    $query = "DELETE FROM pengumuman WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_pengumuman);

    if ($stmt->execute()) {
        header('Location: pengumuman.php'); // Redirect ke halaman pengumuman setelah dihapus
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "ID pengumuman tidak valid.";
    exit;
}
?>
