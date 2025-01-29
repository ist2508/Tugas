<?php
// Mulai session untuk mengakses data login jika diperlukan
session_start();

// Pastikan admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Pastikan ID yang diterima dari URL valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_pendaftar = $_GET['id'];

    // Koneksi ke database
    include '../config/database.php';

    // Query untuk mengambil data pendaftar berdasarkan ID
    $query = "SELECT * FROM pendaftaran WHERE id = ?";
    $stmt = $conn->prepare($query);

    // Bind parameter dan eksekusi query
    $stmt->bind_param("i", $id_pendaftar); // "i" untuk integer
    $stmt->execute();

    // Ambil hasilnya
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Ambil data pendaftar
        $pendaftar = $result->fetch_assoc();
    } else {
        // Jika tidak ada data
        echo "Pendaftar tidak ditemukan.";
        exit;
    }
} else {
    echo "ID tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pendaftar</title>
    <link rel="stylesheet" href="../css/detail_pendaftar.css">
</head>
<body>
    <header>
        <h1>Detail Pendaftar</h1>
    </header>

    <main>
        <section>
            <h2>Informasi Pendaftar</h2>
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td><?php echo htmlspecialchars($pendaftar['nama_lengkap']); ?></td>
                    </tr>
                    <tr>
                        <th>Tempat Lahir</th>
                        <td><?php echo htmlspecialchars($pendaftar['tempat_lahir']); ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td><?php echo htmlspecialchars($pendaftar['tanggal_lahir']); ?></td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td><?php echo htmlspecialchars($pendaftar['jenis_kelamin']); ?></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td><?php echo htmlspecialchars($pendaftar['alamat']); ?></td>
                    </tr>
                    <tr>
                        <th>Provinsi</th>
                        <td><?php echo htmlspecialchars($pendaftar['provinsi']); ?></td>
                    </tr>
                    <tr>
                        <th>Kota/Kabupaten</th>
                        <td><?php echo htmlspecialchars($pendaftar['kota_kabupaten']); ?></td>
                    </tr>
                    <tr>
                        <th>Kecamatan</th>
                        <td><?php echo htmlspecialchars($pendaftar['kecamatan']); ?></td>
                    </tr>
                    <tr>
                        <th>Kelurahan</th>
                        <td><?php echo htmlspecialchars($pendaftar['kelurahan']); ?></td>
                    </tr>
                    <tr>
                        <th>Agama</th>
                        <td><?php echo htmlspecialchars($pendaftar['agama']); ?></td>
                    </tr>
                    <tr>
                        <th>Nama Ayah</th>
                        <td><?php echo htmlspecialchars($pendaftar['nama_ayah']); ?></td>
                    </tr>
                    <tr>
                        <th>Pekerjaan Ayah</th>
                        <td><?php echo htmlspecialchars($pendaftar['pekerjaan_ayah']); ?></td>
                    </tr>
                    <tr>
                        <th>Nama Ibu</th>
                        <td><?php echo htmlspecialchars($pendaftar['nama_ibu']); ?></td>
                    </tr>
                    <tr>
                        <th>Pekerjaan Ibu</th>
                        <td><?php echo htmlspecialchars($pendaftar['pekerjaan_ibu']); ?></td>
                    </tr>
                    <tr>
                        <th>Nama Wali</th>
                        <td><?php echo htmlspecialchars($pendaftar['nama_wali']); ?></td>
                    </tr>
                    <tr>
                        <th>Pekerjaan Wali</th>
                        <td><?php echo htmlspecialchars($pendaftar['pekerjaan_wali']); ?></td>
                    </tr>
                    <!-- Lanjutkan dengan data lainnya jika diperlukan -->
                </thead>
            </table>
        </section>

        <section>
            <!-- Tombol Kembali ke Halaman Index -->
            <a href="index.php" class="button">Kembali ke Daftar Pendaftar</a> |
            <a href="hapus_pendaftar.php?id=<?php echo $pendaftar['id']; ?>" class="button" onclick="return confirm('Apakah Anda yakin ingin menghapus pendaftar ini?')">Hapus</a>
        </section>
    </main>

    <footer>
        <a href="logout.php">Logout</a>
    </footer>
</body>
</html>
