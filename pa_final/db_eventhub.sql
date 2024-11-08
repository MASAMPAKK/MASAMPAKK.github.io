-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Nov 2024 pada 14.53
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_eventhub`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_regis`
--

CREATE TABLE `data_regis` (
  `id_regis` int(11) NOT NULL,
  `id_event` int(11) DEFAULT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `nama_event` varchar(255) DEFAULT NULL,
  `waktu_event` varchar(50) DEFAULT NULL,
  `tanggal_event` date DEFAULT NULL,
  `lokasi_event` varchar(255) DEFAULT NULL,
  `jumlah_tiket` int(11) NOT NULL,
  `tanggal_pemesanan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_regis`
--

INSERT INTO `data_regis` (`id_regis`, `id_event`, `id_pengguna`, `nama_event`, `waktu_event`, `tanggal_event`, `lokasi_event`, `jumlah_tiket`, `tanggal_pemesanan`) VALUES
(2, 33, 4, 'Marathon Day', '07.00 - 11.00', '2024-11-23', 'Center Road', 2, '2024-11-08 15:40:36'),
(4, 34, 4, 'Job Seminar', '10.00 - 12.00', '2024-11-19', 'First Building', 2, '2024-11-08 15:43:25'),
(7, 34, 4, 'Job Seminar', '10.00 - 12.00', '2024-11-19', 'First Building', 2, '2024-11-08 16:27:25'),
(8, 32, 4, 'Food Bazaar', '10.00 - 20.00', '2024-11-18', 'Stadium Yard', 4, '2024-11-08 19:26:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `events`
--

CREATE TABLE `events` (
  `id_event` int(11) NOT NULL,
  `foto_event` varchar(255) NOT NULL,
  `nama_event` varchar(255) NOT NULL,
  `status_event` enum('Gratis','Berbayar') NOT NULL,
  `tanggal_event` date NOT NULL,
  `waktu_event` varchar(50) NOT NULL,
  `lokasi_event` varchar(255) NOT NULL,
  `deskripsi_event` text NOT NULL,
  `harga_tiket` int(255) NOT NULL,
  `kuota_event` int(100) NOT NULL,
  `tanggal_ditambahkan` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `events`
--

INSERT INTO `events` (`id_event`, `foto_event`, `nama_event`, `status_event`, `tanggal_event`, `waktu_event`, `lokasi_event`, `deskripsi_event`, `harga_tiket`, `kuota_event`, `tanggal_ditambahkan`) VALUES
(31, 'uploads/event/concert.jpg', 'Konser Musik', 'Gratis', '2024-11-12', '19.00 - 22.00', 'Stadium Hall', 'blabla', 200000, 188, '2024-11-06 09:09:10'),
(32, 'uploads/event/fnb.jpg', 'Food Bazaar', 'Berbayar', '2024-11-18', '10.00 - 20.00', 'Stadium Yard', 'blabla', 25000, 485, '2024-11-06 15:31:17'),
(34, 'uploads/event/business.jpg', 'Job Seminar', 'Berbayar', '2024-11-19', '10.00 - 12.00', 'First Building', 'blabla', 200000, 0, '2024-11-06 15:35:27'),
(36, 'uploads/event/art.jpg', 'Art Festival', 'Berbayar', '2024-11-10', '19.00 - 22.00', 'Art Building', 'blabla', 150000, 120, '2024-11-06 15:41:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `telp` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sandi` varchar(255) NOT NULL,
  `foto_profil` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_lengkap`, `telp`, `email`, `sandi`, `foto_profil`) VALUES
(1, 'admin', '081234567890', 'admin@gmail.com', '$2y$10$7x/QWhrAXNFM5lkWFB2cquboUexWLrHAASwqtM8ru4tSxb9Gx5a8i', ''),
(4, 'Dhea Puspita', '081258771715', 'dhea@gmail.com', '$2y$10$9Xumk6ZfZYL995eY107ggOy39eFk9xU/0POE68f2k.j0yNkJi/ume', 'uploads/profil/hedgedog.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_regis`
--
ALTER TABLE `data_regis`
  ADD PRIMARY KEY (`id_regis`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indeks untuk tabel `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id_event`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `telp` (`telp`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_regis`
--
ALTER TABLE `data_regis`
  MODIFY `id_regis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `events`
--
ALTER TABLE `events`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_regis`
--
ALTER TABLE `data_regis`
  ADD CONSTRAINT `data_regis_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
