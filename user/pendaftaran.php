<?php
session_start();
include '../config/database.php';
include '../zonasi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama_lengkap = $_POST['nama_lengkap'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $anak_ke = $_POST['anak_ke'];
    $alamat = $_POST['alamat'];
    $provinsi = $_POST['provinsi'];
    $kota_kabupaten = $_POST['kota_kabupaten'];
    $kecamatan = $_POST['kecamatan'];
    $kelurahan = $_POST['kelurahan'];
    $agama = $_POST['agama'];
    $nama_ayah = $_POST['nama_ayah'];
    $pekerjaan_ayah = $_POST['pekerjaan_ayah'];
    $nik_ayah = $_POST['nik_ayah'];
    $penghasilan_ayah = $_POST['penghasilan_ayah'];
    $pendidikan_ayah = $_POST['pendidikan_ayah'];
    $no_telp_ayah = $_POST['no_telp_ayah'];
    $nama_ibu = $_POST['nama_ibu'];
    $pekerjaan_ibu = $_POST['pekerjaan_ibu'];
    $nik_ibu = $_POST['nik_ibu'];
    $penghasilan_ibu = $_POST['penghasilan_ibu'];
    $pendidikan_ibu = $_POST['pendidikan_ibu'];
    $no_telp_ibu = $_POST['no_telp_ibu'];
    $nama_wali = $_POST['nama_wali'];
    $nik_wali = $_POST['nik_wali'];
    $pekerjaan_wali = $_POST['pekerjaan_wali'];
    $no_telp_wali = $_POST['no_telp_wali'];
    $jalur_pendaftaran = isset($_POST['jalur_pendaftaran']) ? $_POST['jalur_pendaftaran'] : '';

    // Folder tujuan untuk menyimpan file
    $upload_dir = '../uploads/';
    $file_paths = [];
    $file_fields = ['akta_kelahiran', 'kartu_keluarga', 'foto', 'bukti_alamat'];
    $upload_success = true;

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";   

    if ($jalur_pendaftaran == 'Prestasi') {
        $file_fields[] = 'sertifikat_prestasi';
    }    

    if ($jalur_pendaftaran == 'Prestasi') {
        if (empty($_FILES['sertifikat_prestasi']['name'])) {
            echo "<script>alert('Harap upload sertifikat prestasi!');</script>";
            exit;
        }
    }      

    foreach ($file_fields as $field) {
        $file_path = $upload_dir . uniqid() . '_' . basename($_FILES[$field]['name']);
        if (move_uploaded_file($_FILES[$field]['tmp_name'], $file_path)) {
            $file_paths[$field] = $file_path;
        } else {
            $upload_success = false;
            break;
        }
    }

    if (!$upload_success) {
        echo "<script>alert('Gagal meng-upload file.');</script>";
        exit;
    }

    $status_id = 2; // Default Tidak Lulus
    $status_name = 'Tidak Lulus';

    if ($jalur_pendaftaran == 'Zonasi') {
        $kuota = 50;
        $query = "SELECT COUNT(*) AS total FROM pendaftaran WHERE status_id = 1";
        $result = $conn->query($query);
        $kuota_terpenuhi = $result->fetch_assoc()['total'] >= $kuota;

        $status_name = checkZonasi($latitude, $longitude, $kuota_terpenuhi);
        $status_id = ($status_name == 'Lulus') ? 1 : 2;
    } elseif ($jalur_pendaftaran == 'Prestasi') {
        $status_id = 1;
        $status_name = 'Lulus';
    }

    // Cek apakah status sudah benar-benar ada sebelum disimpan
    if (empty($status_name)) {
        $status_name = 'Tidak Lulus'; // Default jika tidak ada nilai
    }
    

    // Simpan data ke database
    $query = "INSERT INTO pendaftaran 
        (nama_lengkap, jalur_pendaftaran, tempat_lahir, tanggal_lahir, jenis_kelamin, latitude, longitude, anak_ke, alamat, provinsi, kota_kabupaten, kecamatan, kelurahan, agama, nama_ayah, pekerjaan_ayah, nik_ayah, penghasilan_ayah, pendidikan_ayah, no_telp_ayah, nama_ibu, pekerjaan_ibu, nik_ibu, penghasilan_ibu, pendidikan_ibu, no_telp_ibu, nama_wali, nik_wali, pekerjaan_wali, no_telp_wali, akta_kelahiran, kartu_keluarga, foto, bukti_alamat, sertifikat_prestasi, status_id, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Error pada query prepare: " . $conn->error);
    }

    // Pastikan bahwa $file_paths['sertifikat_prestasi'] memiliki nilai, jika tidak, set ke string kosong
    $sertifikat_prestasi = isset($file_paths['sertifikat_prestasi']) ? $file_paths['sertifikat_prestasi'] : '';

    // Bind parameter
    $stmt->bind_param('sssssdsssssssssssssssssssssssssssssss', 
        $nama_lengkap, $jalur_pendaftaran, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, 
        $latitude, $longitude, $anak_ke, $alamat, $provinsi, 
        $kota_kabupaten, $kecamatan, $kelurahan, $agama, 
        $nama_ayah, $pekerjaan_ayah, $nik_ayah, $penghasilan_ayah, $pendidikan_ayah, $no_telp_ayah, 
        $nama_ibu, $pekerjaan_ibu, $nik_ibu, $penghasilan_ibu, $pendidikan_ibu, $no_telp_ibu, 
        $nama_wali, $nik_wali, $pekerjaan_wali, $no_telp_wali, 
        $file_paths['akta_kelahiran'], $file_paths['kartu_keluarga'], 
        $file_paths['foto'], $file_paths['bukti_alamat'], 
        $sertifikat_prestasi, // Harus ada meskipun kosong
        $status_id, $status_name
    );


    // Eksekusi query
    if ($stmt->execute()) {
        echo "<script>alert('Pendaftaran berhasil!'); window.location.href = 'success.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data: " . $stmt->error . "');</script>";
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran</title>
    <link rel="stylesheet" href="../css/pendaftaran.css">
</head>
<body>
    <div class="container">
    <h1>Formulir Pendaftaran</h1>
    <form method="POST" enctype="multipart/form-data">
        <!-- Data Pribadi -->
        <label for="nama_lengkap">Nama Lengkap:</label>
        <input type="text" id="nama_lengkap" name="nama_lengkap" required>

        <label for="tempat_lahir">Tempat Lahir:</label>
        <input type="text" id="tempat_lahir" name="tempat_lahir" required>

        <label for="tanggal_lahir">Tanggal Lahir:</label>
        <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>

        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select id="jenis_kelamin" name="jenis_kelamin" required>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
        </select>

        <label for="anak_ke">Anak Ke:</label>
        <input type="number" id="anak_ke" name="anak_ke" required>

        <label for="alamat">Alamat:</label>
        <textarea id="alamat" name="alamat" required></textarea>

        <label for="provinsi">Provinsi:</label>
        <input type="text" id="provinsi" name="provinsi" required>

        <label for="kota_kabupaten">Kota/Kabupaten:</label>
        <input type="text" id="kota_kabupaten" name="kota_kabupaten" required>

        <label for="kecamatan">Kecamatan:</label>
        <input type="text" id="kecamatan" name="kecamatan" required>

        <label for="kelurahan">Kelurahan:</label>
        <input type="text" id="kelurahan" name="kelurahan" required>

        <label for="agama">Agama:</label>
        <input type="text" id="agama" name="agama" required>

        <!-- Data Ayah -->
        <h3>Data Ayah:</h3>
        <label for="nama_ayah">Nama Ayah:</label>
        <input type="text" id="nama_ayah" name="nama_ayah" required>

        <label for="pekerjaan_ayah">Pekerjaan Ayah:</label>
        <input type="text" id="pekerjaan_ayah" name="pekerjaan_ayah" required>

        <label for="nik_ayah">NIK Ayah:</label>
        <input type="text" id="nik_ayah" name="nik_ayah" required>

        <label for="penghasilan_ayah">Penghasilan Ayah:</label>
        <input type="number" id="penghasilan_ayah" name="penghasilan_ayah" required>

        <label for="pendidikan_ayah">Pendidikan Ayah:</label>
        <input type="text" id="pendidikan_ayah" name="pendidikan_ayah" required>

        <label for="no_telp_ayah">No Telp Ayah:</label>
        <input type="text" id="no_telp_ayah" name="no_telp_ayah" required>

        <!-- Data Ibu -->
        <h3>Data Ibu:</h3>
        <label for="nama_ibu">Nama Ibu:</label>
        <input type="text" id="nama_ibu" name="nama_ibu" required>

        <label for="pekerjaan_ibu">Pekerjaan Ibu:</label>
        <input type="text" id="pekerjaan_ibu" name="pekerjaan_ibu" required>

        <label for="nik_ibu">NIK Ibu:</label>
        <input type="text" id="nik_ibu" name="nik_ibu" required>

        <label for="penghasilan_ibu">Penghasilan Ibu:</label>
        <input type="number" id="penghasilan_ibu" name="penghasilan_ibu" required>

        <label for="pendidikan_ibu">Pendidikan Ibu:</label>
        <input type="text" id="pendidikan_ibu" name="pendidikan_ibu" required>

        <label for="no_telp_ibu">No Telp Ibu:</label>
        <input type="text" id="no_telp_ibu" name="no_telp_ibu" required>

        <!-- Data Wali -->
        <h3>Data Wali:</h3>
        <label for="nama_wali">Nama Wali:</label>
        <input type="text" id="nama_wali" name="nama_wali" required>

        <label for="nik_wali">NIK Wali:</label>
        <input type="text" id="nik_wali" name="nik_wali" required>

        <label for="pekerjaan_wali">Pekerjaan Wali:</label>
        <input type="text" id="pekerjaan_wali" name="pekerjaan_wali" required>

        <label for="no_telp_wali">No Telp Wali:</label>
        <input type="text" id="no_telp_wali" name="no_telp_wali" required>

        <!-- Upload File -->
        <label for="akta_kelahiran">Akta Kelahiran:</label>
        <input type="file" id="akta_kelahiran" name="akta_kelahiran" required>

        <label for="kartu_keluarga">Kartu Keluarga:</label>
        <input type="file" id="kartu_keluarga" name="kartu_keluarga" required>

        <label for="foto">Foto:</label>
        <input type="file" id="foto" name="foto" required>

        <label for="bukti_alamat">Bukti Alamat:</label>
        <input type="file" id="bukti_alamat" name="bukti_alamat" required>

        <label for="jalur_pendaftaran">Jalur Pendaftaran:</label>
        <select id="jalur_pendaftaran" name="jalur_pendaftaran" onchange="togglePrestasi()">
            <option value="Zonasi">Zonasi</option>
            <option value="Prestasi">Prestasi</option>
        </select>

        <div id="sertifikat_prestasi_container" style="display: none;">
            <label for="sertifikat_prestasi">Upload Sertifikat Prestasi:</label>
            <input type="file" id="sertifikat_prestasi" name="sertifikat_prestasi" accept=".pdf,.jpg,.png">
        </div>

        <script>
        function togglePrestasi() {
            var jalur = document.getElementById("jalur_pendaftaran").value;
            var sertifikatContainer = document.getElementById("sertifikat_prestasi_container");
            
            if (jalur === "Prestasi") {
                sertifikatContainer.style.display = "block";
            } else {
                sertifikatContainer.style.display = "none";
            }
        }
        </script>

        <!-- Lokasi -->
        <label for="latitude">Latitude:</label>
        <input type="text" id="latitude" name="latitude" readonly required>

        <label for="longitude">Longitude:</label>
        <input type="text" id="longitude" name="longitude" readonly required>

        <button type="button" id="get-location">Ambil Lokasi</button>
        <button type="submit">Daftar</button>
    </form>

    <script>
        document.getElementById('get-location').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                    alert('Lokasi berhasil diambil!');
                }, function(error) {
                    alert('Gagal mendapatkan lokasi. Pastikan izin lokasi diaktifkan.');
                });
            } else {
                alert('Geolocation tidak didukung di browser Anda.');
            }
        }
    );
        
    </script>
    </div>
</body>
</html>
