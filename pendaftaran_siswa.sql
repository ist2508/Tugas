-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Jan 2025 pada 19.43
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pendaftaran_siswa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `document_type` enum('foto','akta','kk','ijazah_tk','alamat') NOT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `parents`
--

CREATE TABLE `parents` (
  `id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `mother_name` varchar(255) NOT NULL,
  `father_nik` varchar(16) NOT NULL,
  `mother_nik` varchar(16) NOT NULL,
  `father_job` varchar(255) DEFAULT NULL,
  `mother_job` varchar(255) DEFAULT NULL,
  `father_income` decimal(10,2) DEFAULT NULL,
  `mother_income` decimal(10,2) DEFAULT NULL,
  `father_education` varchar(255) DEFAULT NULL,
  `mother_education` varchar(255) DEFAULT NULL,
  `father_phone` varchar(15) DEFAULT NULL,
  `mother_phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `anak_ke` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `provinsi` varchar(50) NOT NULL,
  `kota_kabupaten` varchar(50) NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `kelurahan` varchar(50) NOT NULL,
  `agama` varchar(20) NOT NULL,
  `nama_ayah` varchar(100) NOT NULL,
  `pekerjaan_ayah` varchar(50) NOT NULL,
  `nik_ayah` varchar(16) NOT NULL,
  `penghasilan_ayah` decimal(10,2) NOT NULL,
  `pendidikan_ayah` varchar(50) NOT NULL,
  `nama_ibu` varchar(100) NOT NULL,
  `pekerjaan_ibu` varchar(50) NOT NULL,
  `nik_ibu` varchar(16) NOT NULL,
  `penghasilan_ibu` decimal(10,2) NOT NULL,
  `pendidikan_ibu` varchar(50) NOT NULL,
  `no_telp_ayah` varchar(15) DEFAULT NULL,
  `no_telp_ibu` varchar(15) DEFAULT NULL,
  `nama_wali` varchar(100) DEFAULT NULL,
  `nik_wali` varchar(16) DEFAULT NULL,
  `pekerjaan_wali` varchar(50) DEFAULT NULL,
  `no_telp_wali` varchar(15) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `akta_kelahiran` varchar(255) DEFAULT NULL,
  `kartu_keluarga` varchar(255) DEFAULT NULL,
  `bukti_alamat` varchar(255) DEFAULT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `status_id` int(11) DEFAULT NULL,
  `status` enum('Lulus','Tidak Lulus') DEFAULT 'Tidak Lulus',
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pendaftaran`
--

INSERT INTO `pendaftaran` (`id`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `anak_ke`, `alamat`, `provinsi`, `kota_kabupaten`, `kecamatan`, `kelurahan`, `agama`, `nama_ayah`, `pekerjaan_ayah`, `nik_ayah`, `penghasilan_ayah`, `pendidikan_ayah`, `nama_ibu`, `pekerjaan_ibu`, `nik_ibu`, `penghasilan_ibu`, `pendidikan_ibu`, `no_telp_ayah`, `no_telp_ibu`, `nama_wali`, `nik_wali`, `pekerjaan_wali`, `no_telp_wali`, `foto`, `akta_kelahiran`, `kartu_keluarga`, `bukti_alamat`, `latitude`, `longitude`, `status_id`, `status`, `user_id`, `created_at`) VALUES
(7, 'Ista Nurlia Tolanto', 'Baubau', '2018-04-04', '', 1, 'Jln. Anoa No.33', 'Sulawesi Tenggara', 'KOTA BAUBAU', 'Kokalukuna', 'Kadolomoko', 'Islam', 'Ista', 'PNS', '1234567890', '5000000.00', 'S2', 'Ista', 'PNS', '1234567890', '5000000.00', 'S2', '08123456789', '08123456789', 'Ista', '1234567890', 'PNS', '08123456789', '../uploads/6791e5886e8bd_Kopi Tarek Aceh.jpg', '../uploads/6791e5886e4c6_Iphone wallpaper watercolor.jpg', '../uploads/6791e5886e68a_Background triangle blue.jpg', '../uploads/6791e5886e9fe_NASI PUTIH.png', -5.4668175, 122.6164299, 1, 'Lulus', NULL, '2025-01-23 06:49:43'),
(9, 'Ista Nurlia Tolanto', 'Baubau', '2025-01-04', 'Perempuan', 4, 'Jln. Anoa No.33', 'Sulawesi Tenggara', 'KOTA BAUBAU', 'Kokalukuna', 'Kadolomoko', 'Islam', 'Ista', 'PNS', '1234567890', '5000000.00', 'S2', 'Ista', 'PNS', '1234567890', '5000000.00', 'S2', '08123456789', '08123456789', 'Ista', '1234567890', 'PNS', '08123456789', '../uploads/6793c0316d5cd_Kopi Tarek Aceh.jpg', '../uploads/6793c0316cf8f_animated city of England.png', '../uploads/6793c0316d3c7_Flowchart Naive Bayes.jpg', '../uploads/6793c0316d727_HealthMate_logo_with_healthy_food_and_the_text_HealthMate__1_-removebg-preview.png', -5.4668175, 122.6164299, 1, 'Lulus', NULL, '2025-01-24 16:30:41'),
(10, 'Ista Nurlia Tolanto', 'Baubau', '2025-01-04', 'Perempuan', 4, 'Jln. Anoa No.33', 'Sulawesi Tenggara', 'KOTA BAUBAU', 'Kokalukuna', 'Kadolomoko', 'Islam', 'Ista', 'PNS', '1234567890', '5000000.00', 'S2', 'Ista', 'PNS', '1234567890', '5000000.00', 'S2', '08123456789', '08123456789', 'Ista', '1234567890', 'PNS', '08123456789', '../uploads/6793c1091576e_Kopi Tarek Aceh.jpg', '../uploads/6793c109153c2_animated city of England.png', '../uploads/6793c10915579_Flowchart Naive Bayes.jpg', '../uploads/6793c10915a97_HealthMate_logo_with_healthy_food_and_the_text_HealthMate__1_-removebg-preview.png', -5.4668175, 122.6164299, 1, 'Lulus', NULL, '2025-01-24 16:34:17'),
(11, 'Ista Nurlia Tolanto', 'Baubau', '2025-01-04', 'Perempuan', 4, 'Jln. Anoa No.33', 'Sulawesi Tenggara', 'KOTA BAUBAU', 'Kokalukuna', 'Kadolomoko', 'Islam', 'Ista', 'PNS', '1234567890', '5000000.00', 'S2', 'Ista', 'PNS', '1234567890', '5000000.00', 'S2', '08123456789', '08123456789', 'Ista', '1234567890', 'PNS', '08123456789', '../uploads/6793c19884d21_Kopi Tarek Aceh.jpg', '../uploads/6793c19884850_animated city of England.png', '../uploads/6793c19884ac6_Flowchart Naive Bayes.jpg', '../uploads/6793c198850c5_HealthMate_logo_with_healthy_food_and_the_text_HealthMate__1_-removebg-preview.png', -5.4668175, 122.6164299, 1, 'Lulus', NULL, '2025-01-24 16:36:40'),
(12, 'Ista Nurlia Tolanto', 'Baubau', '2025-01-04', 'Perempuan', 4, 'Jln. Anoa No.33', 'Sulawesi Tenggara', 'KOTA BAUBAU', 'Kokalukuna', 'Kadolomoko', 'Islam', 'Ista', 'PNS', '1234567890', '5000000.00', 'S2', 'Ista', 'PNS', '1234567890', '5000000.00', 'S2', '08123456789', '08123456789', 'Ista', '1234567890', 'PNS', '08123456789', '../uploads/6793c1e1dbe40_Kopi Tarek Aceh.jpg', '../uploads/6793c1e1db60a_animated city of England.png', '../uploads/6793c1e1db955_Flowchart Naive Bayes.jpg', '../uploads/6793c1e1dc2b9_HealthMate_logo_with_healthy_food_and_the_text_HealthMate__1_-removebg-preview.png', -5.4601721, 122.6241153, 1, 'Lulus', NULL, '2025-01-24 16:37:53'),
(13, 'Ista Nurlia Tolanto', 'Baubau', '2025-01-04', 'Perempuan', 4, 'Jln. Anoa No.33', 'Sulawesi Tenggara', 'KOTA BAUBAU', 'Kokalukuna', 'Kadolomoko', 'Islam', 'Ista', 'PNS', '1234567890', '5000000.00', 'S2', 'Ista', 'PNS', '1234567890', '5000000.00', 'S2', '08123456789', '08123456789', 'Ista', '1234567890', 'PNS', '08123456789', '../uploads/6793c1f0596a3_Kopi Tarek Aceh.jpg', '../uploads/6793c1f0591bd_animated city of England.png', '../uploads/6793c1f059411_Flowchart Naive Bayes.jpg', '../uploads/6793c1f05c98b_HealthMate_logo_with_healthy_food_and_the_text_HealthMate__1_-removebg-preview.png', -5.4601721, 122.6241153, 1, 'Lulus', NULL, '2025-01-24 16:38:08'),
(14, 'Ista Nurlia Tolanto', 'Baubau', '2025-01-04', 'Perempuan', 4, 'Jln. Anoa No.33', 'Sulawesi Tenggara', 'KOTA BAUBAU', 'Kokalukuna', 'Kadolomoko', 'Islam', 'Ista', 'PNS', '1234567890', '5000000.00', 'S2', 'Ista', 'PNS', '1234567890', '5000000.00', 'S2', '08123456789', '08123456789', 'Ista', '1234567890', 'PNS', '08123456789', '../uploads/6793c6972fdf9_Kopi Tarek Aceh.jpg', '../uploads/6793c6972fa79_animated city of England.png', '../uploads/6793c6972fc31_Flowchart Naive Bayes.jpg', '../uploads/6793c6972ffe7_HealthMate_logo_with_healthy_food_and_the_text_HealthMate__1_-removebg-preview.png', -5.4668175, 122.6164299, 1, 'Lulus', NULL, '2025-01-24 16:57:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `konten` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul`, `konten`, `created_at`) VALUES
(3, 'Penerimaan Siswa Baru', 'assdsdas', '2025-01-25 02:36:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `birth_place` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `child_order` int(11) NOT NULL,
  `address` text NOT NULL,
  `distance_km` float NOT NULL,
  `status` enum('lolos','gagal') DEFAULT 'gagal',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `status_name` enum('Lulus','Tidak Lulus') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `status`
--

INSERT INTO `status` (`id`, `status_name`) VALUES
(1, 'Lulus'),
(2, 'Tidak Lulus');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'ista', '$2y$10$6OWKluNhefxC0.w/L8g5YObboDCNxqut2clhoan6SCQWg3eOHBywO', 'user'),
(2, 'admin', '$2y$10$/Uw2VbFGI9jYkOF3aVlGwejwNkHRvUuYK/AQ2cn01hLbNEVG47N66', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `zonasi`
--

CREATE TABLE `zonasi` (
  `id` int(11) NOT NULL,
  `wilayah` varchar(255) NOT NULL,
  `kuota` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registration_id` (`registration_id`);

--
-- Indeks untuk tabel `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registration_id` (`registration_id`);

--
-- Indeks untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_status` (`status_id`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `zonasi`
--
ALTER TABLE `zonasi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `parents`
--
ALTER TABLE `parents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `zonasi`
--
ALTER TABLE `zonasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `parents_ibfk_1` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `fk_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);

--
-- Ketidakleluasaan untuk tabel `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
