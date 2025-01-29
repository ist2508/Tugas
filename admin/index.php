<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

include '../config/database.php';

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data pendaftar
$query_pendaftar = "
    SELECT 
        p.id AS id_pendaftaran, 
        p.nama_lengkap, 
        p.jalur_pendaftaran, 
        p.status, 
        p.alamat, 
        p.created_at
    FROM pendaftaran p
    LEFT JOIN users u ON p.user_id = u.id
    ORDER BY p.id DESC
";

$result_pendaftar = $conn->query($query_pendaftar);
if (!$result_pendaftar) {
    die("Error pada query pendaftar: " . $conn->error);
}

$pendaftar = [];
while ($p = $result_pendaftar->fetch_assoc()) {
    $pendaftar[] = $p;
}

// Ambil pengumuman dari database
$query_pengumuman = "SELECT * FROM pengumuman ORDER BY created_at DESC LIMIT 1"; // Ambil pengumuman terbaru
$result_pengumuman = $conn->query($query_pengumuman);
if (!$result_pengumuman) {
    die("Error pada query pengumuman: " . $conn->error);
}
$pengumuman = $result_pengumuman->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Data Pendaftar</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <header>
        <h1>Dashboard Admin - Data Pendaftar</h1>
    </header>

    <main>
        <!-- Section Pengumuman -->
        <section id="pengumuman">
            <h2>Pengumuman Terbaru</h2>
            <?php if ($pengumuman): ?>
                <div class="pengumuman-box">
                    <h3><?php echo htmlspecialchars($pengumuman['judul']); ?></h3>
                    <p><?php echo nl2br(htmlspecialchars($pengumuman['konten'])); ?></p>
                    <p><small><?php echo htmlspecialchars($pengumuman['created_at']); ?></small></p>
                </div>
            <?php else: ?>
                <p>Belum ada pengumuman terbaru.</p>
            <?php endif; ?>
        </section>

        <!-- Section Data Pendaftar -->
        <section>
    <h2>Daftar Pendaftar</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID Pendaftaran</th>
                <th>Nama Lengkap</th>
                <th>Jalur Pendaftaran</th>
                <th>Status Pendaftaran</th>
                <th>Alamat</th>
                <th>Tanggal Pendaftaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($pendaftar) > 0): ?>
                <?php foreach ($pendaftar as $p): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($p['id_pendaftaran']); ?></td>
                        <td><?php echo htmlspecialchars($p['nama_lengkap']); ?></td>
                        <td><?php echo htmlspecialchars($p['jalur_pendaftaran']); ?></td>
                        <td><?php echo ucfirst($p['status']); ?></td>
                        <td><?php echo htmlspecialchars($p['alamat']); ?></td>
                        <td><?php echo htmlspecialchars($p['created_at']); ?></td>
                        <td>
                            <a href="detail_pendaftar.php?id=<?php echo $p['id_pendaftaran']; ?>">Detail</a> |  
                            <a href="hapus_pendaftar.php?id=<?php echo $p['id_pendaftaran']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pendaftar ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Tidak ada data pendaftar.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

        <!-- Tombol ke Tambah Pengumuman -->
        <section>
            <a href="pengumuman.php" class="button">Tambah Pengumuman</a>
        </section>
    </main>

    <footer>
        <a href="logout.php">Logout</a>
    </footer>
</body>
</html>
