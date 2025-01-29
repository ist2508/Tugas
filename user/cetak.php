<?php
require '../vendor/autoload.php'; // Pastikan path Dompdf benar
use Dompdf\Dompdf;

include '../config/database.php';

// Debugging: Periksa apakah ID dikirim
if (!isset($_POST['id']) || empty($_POST['id'])) {
    die("ID pendaftaran tidak dikirim.");
}

// Ambil ID pendaftaran dari POST
$id = $_POST['id'];

// Debugging: Tampilkan ID untuk memastikan diterima dengan benar
// echo "ID Pendaftaran: " . $id;

// Query untuk mengambil data berdasarkan ID
$query = "SELECT * FROM pendaftaran WHERE id = $id";
$result = $conn->query($query);

// Debugging: Periksa apakah query berhasil
if (!$result) {
    die("Error pada query: " . $conn->error);
}

// Cek apakah data ditemukan
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    die("Pendaftaran tidak ditemukan. Pastikan data sudah terdaftar.");
}

// Generate PDF
$dompdf = new Dompdf();

$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumen Pendaftaran</title>
</head>
<body>
    <h1>Dokumen Pendaftaran</h1>
    <p><strong>Nama Lengkap:</strong> ' . htmlspecialchars($data['nama_lengkap']) . '</p>
    <p><strong>Tempat Lahir:</strong> ' . htmlspecialchars($data['tempat_lahir']) . '</p>
    <p><strong>Tanggal Lahir:</strong> ' . htmlspecialchars($data['tanggal_lahir']) . '</p>
    <p><strong>Jenis Kelamin:</strong> ' . htmlspecialchars($data['jenis_kelamin']) . '</p>
    <p><strong>Alamat:</strong> ' . htmlspecialchars($data['alamat']) . '</p>
    <p><strong>Provinsi:</strong> ' . htmlspecialchars($data['provinsi']) . '</p>
    <p><strong>Kota/Kabupaten:</strong> ' . htmlspecialchars($data['kota_kabupaten']) . '</p>
    <p><strong>Foto:</strong></p>
    <img src="../uploads/' . htmlspecialchars($data['foto']) . '" alt="Foto Pendaftar" width="150">
</body>
</html>
';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Dokumen_Pendaftaran_" . $data['nama_lengkap'] . ".pdf", ["Attachment" => true]);
?>
