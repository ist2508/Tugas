<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

include '../config/database.php';

// Ambil pengumuman dari database
$query_pengumuman = "SELECT * FROM pengumuman ORDER BY created_at DESC";
$result_pengumuman = $conn->query($query_pengumuman);

if (!$result_pengumuman) {
    die("Error pada query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman - Admin</title>
    <link rel="stylesheet" href="../css/pengumuman.css">
</head>
<body>
    <header>
        <h1>Pengumuman</h1>
    </header>

    <main>
        <section>
            <h2>Daftar Pengumuman</h2>
            <?php if ($result_pengumuman->num_rows > 0): ?>
                <table border="1" cellpadding="10" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Konten</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($pengumuman = $result_pengumuman->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($pengumuman['judul']); ?></td>
                                <td><?php echo nl2br(htmlspecialchars($pengumuman['konten'])); ?></td>
                                <td><?php echo htmlspecialchars($pengumuman['created_at']); ?></td>
                                <td>
                                    <!-- Tombol Edit dan Hapus -->
                                    <a href="edit_pengumuman.php?id=<?php echo $pengumuman['id']; ?>" class="button">Edit</a>
                                    <a href="hapus_pengumuman.php?id=<?php echo $pengumuman['id']; ?>" class="button" onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Tidak ada pengumuman yang tersedia.</p>
            <?php endif; ?>
        </section>

        <!-- Tombol Tambah Pengumuman -->
        <a href="tambah_pengumuman.php" class="button">Tambah Pengumuman</a>
    </main>

    <footer>
        <!-- Tombol Kembali ke Beranda Admin -->
        <a href="index.php" class="button">Kembali ke Beranda Admin</a>
        <a href="logout.php" class="button">Logout</a>
    </footer>
</body>
</html>
