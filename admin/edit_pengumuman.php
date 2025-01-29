<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

include '../config/database.php';

// Ambil ID pengumuman yang ingin diedit
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    // Ambil data pengumuman berdasarkan ID
    $query = "SELECT * FROM pengumuman WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pengumuman = $result->fetch_assoc();

    if (!$pengumuman) {
        echo "Pengumuman tidak ditemukan.";
        exit;
    }
} else {
    echo "ID pengumuman tidak valid.";
    exit;
}

// Proses edit pengumuman
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['judul']) && isset($_POST['konten'])) {
    $judul = $_POST['judul'];
    $konten = $_POST['konten'];

    $query_update = "UPDATE pengumuman SET judul = ?, konten = ?, created_at = NOW() WHERE id = ?";
    $stmt_update = $conn->prepare($query_update);
    $stmt_update->bind_param("ssi", $judul, $konten, $id);

    if ($stmt_update->execute()) {
        header('Location: pengumuman.php');
        exit;
    } else {
        echo "Error: " . $stmt_update->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengumuman</title>
    <link rel="stylesheet" href="../css/edithapus.css">
</head>
<body>
    <header>
        <h1>Edit Pengumuman</h1>
    </header>

    <main>
        <section>
            <form method="POST">
                <label for="judul">Judul:</label>
                <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($pengumuman['judul']); ?>" required><br>

                <label for="konten">Konten:</label><br>
                <textarea id="konten" name="konten" rows="5" required><?php echo htmlspecialchars($pengumuman['konten']); ?></textarea><br>

                <button type="submit">Simpan Perubahan</button>
            </form>
        </section>

        <section>
            <a href="pengumuman.php" class="button">Kembali ke Daftar Pengumuman</a>
        </section>
    </main>

    <footer>
        <a href="logout.php">Logout</a>
    </footer>
</body>
</html>
