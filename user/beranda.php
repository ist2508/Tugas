<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include '../config/database.php';

// Ambil pengumuman dari database
$query_pengumuman = "SELECT * FROM pengumuman ORDER BY created_at DESC LIMIT 5"; // Mengambil 5 pengumuman terbaru
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
    <title>Beranda User</title>
    <link rel="stylesheet" href="../css/berandauser.css">
</head>
<body>
<header>
    <div class="header-content">
        <img src="../images/2logo-sdn7.png" alt="Logo SDN 7 Baubau" class="logo">
        <div>
            <h1>Pendaftaran Siswa Baru Sekolah Dasar</h1>
            <h2>SD NEGERI 7 BAUBAU</h2>
        </div>
    </div>
</header>

<main>
    <section>
        <h2>Persyaratan Pendaftaran</h2>
        <ul>
            <li>Akta Kelahiran</li>
            <li>Kartu Keluarga</li>
            <li>Foto</li>
            <li>Bukti Alamat</li>
        </ul>
    </section>

    <!-- Menampilkan Pengumuman -->
    <section>
        <h2>Pengumuman Terbaru</h2>
        <?php if ($result_pengumuman->num_rows > 0): ?>
            <ul>
                <?php while ($pengumuman = $result_pengumuman->fetch_assoc()): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($pengumuman['judul']); ?></strong><br>
                        <p><?php echo nl2br(htmlspecialchars($pengumuman['konten'])); ?></p>
                        <small><?php echo "Tanggal: " . htmlspecialchars($pengumuman['created_at']); ?></small>
                    </li>
                    <hr>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Tidak ada pengumuman terbaru.</p>
        <?php endif; ?>
    </section>

    <section>
        <!-- Tombol untuk menuju halaman pendaftaran -->
        <a href="pendaftaran.php" class="button">Mulai Pendaftaran</a>
        <!-- Tombol untuk logout -->
        <a href="logout.php" class="button">Logout</a>
    </section>
</main>

<footer>
    <p>&copy; 2025 Sistem Pendaftaran SD Zonasi</p>
</footer>
</body>
</html>
