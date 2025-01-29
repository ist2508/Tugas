<?php
session_start();
include 'config/database.php';

// Tangkap data dari form
$nama_lengkap = $_POST['nama_lengkap'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$foto = $_FILES['foto']['name'];

// Path untuk menyimpan foto
$target_dir = "uploads/";
$target_file = $target_dir . basename($foto);

// Upload file
if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
    // Simpan data ke database
    $query = "INSERT INTO pendaftaran (nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, foto) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $nama_lengkap, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $target_file);
    
    if ($stmt->execute()) {
        // Redirect ke halaman cetak dokumen dengan ID pendaftar
        $id_pendaftar = $stmt->insert_id;
        header("Location: cetak_dokumen.php?id=$id_pendaftar");
        exit;
    } else {
        echo "Gagal menyimpan data.";
    }
} else {
    echo "Gagal mengunggah foto.";
}
?>
