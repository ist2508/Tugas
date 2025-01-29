<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $judul = $_POST['judul'];
    $konten = $_POST['konten'];

    // Query untuk menambahkan pengumuman baru
    $query = "INSERT INTO pengumuman (judul, konten, created_at) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $judul, $konten);

    if ($stmt->execute()) {
        // Redirect ke halaman daftar pengumuman setelah berhasil menambahkan
        header('Location: pengumuman.php');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengumuman</title>
    <link rel="stylesheet" href="../css/tambah_pengumuman.css">
</head>
<body>
    <header>
        <h1>Tambah Pengumuman</h1>
    </header>

    <main>
        <section>
            <h2>Form Tambah Pengumuman</h2>
            <form method="POST">
                <label for="judul">Judul:</label>
                <input type="text" id="judul" name="judul" required><br>

                <label for="konten">Konten:</label><br>
                <textarea id="konten" name="konten" rows="5" required></textarea><br>

                <button type="submit">Tambah Pengumuman</button>
            </form>
        </section>

        <a href="pengumuman.php" class="button">Kembali ke Daftar Pengumuman</a>
    </main>

    <footer>
        <a href="logout.php" class="button">Logout</a>
    </footer>
</body>
</html>
