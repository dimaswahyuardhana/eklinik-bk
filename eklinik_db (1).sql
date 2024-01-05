-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2024 at 01:16 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eklinik_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `daftar_poli`
--

CREATE TABLE `daftar_poli` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_pasien` int(11) UNSIGNED NOT NULL,
  `id_jadwal` int(11) UNSIGNED NOT NULL,
  `keluhan` text NOT NULL,
  `no_antrian` int(11) UNSIGNED NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `daftar_poli`
--

INSERT INTO `daftar_poli` (`id`, `id_pasien`, `id_jadwal`, `keluhan`, `no_antrian`, `tanggal`) VALUES
(4, 4, 3, 'Mata saya ada dua', 1, '2023-12-31 07:31:36'),
(5, 5, 4, 'Kulit saya kurang putih', 1, '2023-12-31 07:32:39'),
(6, 6, 5, 'Gigi saya pengen dikawat ', 1, '2023-12-31 07:33:52'),
(7, 7, 6, 'Tulang saya pengen dipijit', 1, '2023-12-31 07:34:54'),
(8, 4, 4, 'Kulit berjerawat', 2, '2023-12-31 08:16:29'),
(9, 5, 3, 'Mata ', 2, '2023-12-31 08:19:57'),
(10, 6, 3, 'Mata bengkak', 3, '2023-12-31 13:08:39'),
(11, 7, 5, 'gigi ngilu', 2, '2024-01-04 15:57:15'),
(12, 8, 3, 'Mata kunang-kunang', 4, '2024-01-05 11:56:49'),
(13, 5, 7, 'Mata sebelah terasa sempit', 1, '2024-01-05 12:08:42'),
(14, 5, 3, 'Mata kanan terasa berat', 5, '2024-01-05 12:09:04'),
(15, 7, 3, 'Mata kanan bengkak ', 6, '2024-01-05 12:09:55');

-- --------------------------------------------------------

--
-- Table structure for table `detail_periksa`
--

CREATE TABLE `detail_periksa` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_periksa` int(11) UNSIGNED NOT NULL,
  `id_obat` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_periksa`
--

INSERT INTO `detail_periksa` (`id`, `id_periksa`, `id_obat`) VALUES
(2, 2, 10),
(3, 3, 12),
(4, 4, 12),
(5, 5, 12),
(6, 6, 11);

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `id_poli` int(11) UNSIGNED NOT NULL,
  `nip` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id`, `nama`, `alamat`, `no_hp`, `id_poli`, `nip`, `password`) VALUES
(18, 'dr. Dimas', 'Jepara', '082322345597', 3, '10122001', '$2y$10$a5o7gBYSIn8IpnMaCiShru/g9gLeenGIztpAvTMmhAXFVzPoIoJ1u'),
(19, 'dr. Rizza', 'Pati', '087678567787', 5, '29042002', '$2y$10$kT.eeOqsmsNblftTXPEeS.PQIvlupjXUJI6NeGFV6ZuhUL6Bo/o0K'),
(20, 'dr. Rizal', 'Demak', '087564675789', 1, '313131', '$2y$10$oHM3hyjx/h/Ma2z9PgpFHeKhJvrRATtFwHbxkvcdqSbxjeeIdh3K2'),
(21, 'dr. Fuat', 'Wonosobo', '089767897879', 6, '121212', '$2y$10$hfWnTa7Q9qZKMrfD.gFWt.qnQ6AjgDPOlTrUcQ.o5xds6Fqrq6FV6');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_periksa`
--

CREATE TABLE `jadwal_periksa` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_dokter` int(11) UNSIGNED NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwal_periksa`
--

INSERT INTO `jadwal_periksa` (`id`, `id_dokter`, `hari`, `jam_mulai`, `jam_selesai`) VALUES
(3, 18, 'Senin', '09:00:00', '11:00:00'),
(4, 19, 'Selasa', '10:00:00', '12:00:00'),
(5, 20, 'Rabu', '11:00:00', '13:00:00'),
(6, 21, 'Kamis', '13:00:00', '15:00:00'),
(7, 18, 'Jumat', '13:00:00', '15:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_obat` varchar(50) NOT NULL,
  `kemasan` varchar(35) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id`, `nama_obat`, `kemasan`, `harga`) VALUES
(10, 'Neuralgin', 'Strip', 5000),
(11, 'Bodrex', 'Strip', 2000),
(12, 'Paracetamol', 'Strip', 7000);

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_ktp` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `no_rm` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id`, `nama`, `alamat`, `no_ktp`, `no_hp`, `no_rm`) VALUES
(4, 'Mayong', 'Brebes', '010101', '089765678765', '202312-001'),
(5, 'Agung', 'Demak', '020202', '089767897879', '202312-002'),
(6, 'Didin', 'Pati', '030303', '089767897879', '202312-003'),
(7, 'Aan', 'Pati', '040404', '087564675789', '202312-004'),
(8, 'Della Risqi ', 'Jepara', '15112002', '087678567787', '202401-001'),
(9, 'Fahri Alfian', 'Demak', '050505', '089765678765', '202401-002');

-- --------------------------------------------------------

--
-- Table structure for table `periksa`
--

CREATE TABLE `periksa` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_daftar_poli` int(11) UNSIGNED NOT NULL,
  `tgl_periksa` datetime NOT NULL,
  `catatan` text NOT NULL,
  `biaya_periksa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `periksa`
--

INSERT INTO `periksa` (`id`, `id_daftar_poli`, `tgl_periksa`, `catatan`, `biaya_periksa`) VALUES
(1, 10, '2024-01-04 15:42:02', 'jangan makan telat', 150000),
(2, 10, '2024-01-04 15:42:11', 'jangan makan telat', 155000),
(3, 9, '2024-01-04 16:37:31', 'makan mulu ', 157000),
(4, 8, '2024-01-04 16:52:05', 'Harus sering mandi ', 157000),
(5, 7, '2024-01-04 16:53:54', 'jangan banyak atraksi ', 157000),
(6, 12, '2024-01-05 12:57:53', 'ditetes', 152000);

-- --------------------------------------------------------

--
-- Table structure for table `poli`
--

CREATE TABLE `poli` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_poli` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `poli`
--

INSERT INTO `poli` (`id`, `nama_poli`, `keterangan`) VALUES
(1, 'Gigi', 'Poliklinik Gigi'),
(3, 'Mata', 'Poliklinik Mata'),
(5, 'Kulit dan Kelamin', 'Manjur'),
(6, 'Ortopedi', 'Ahli tulang ');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`, `role`) VALUES
(6, 'admin', 'admin', '$2y$10$x9DUll82zt3c85rdnU8G9uFhGKqCIHBW4tsx1wXyFm5gIIS9yUydq', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pasien_daftar_poli` (`id_pasien`),
  ADD KEY `fk_daftar_jadwal_periksa` (`id_jadwal`);

--
-- Indexes for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detail_periksa` (`id_periksa`),
  ADD KEY `fk_detail_periksa_obat` (`id_obat`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dokter_poli` (`id_poli`);

--
-- Indexes for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dokter_jadwal_periksa` (`id_dokter`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periksa`
--
ALTER TABLE `periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_periksa_daftar_poli` (`id_daftar_poli`);

--
-- Indexes for table `poli`
--
ALTER TABLE `poli`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `periksa`
--
ALTER TABLE `periksa`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `poli`
--
ALTER TABLE `poli`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD CONSTRAINT `fk_daftar_jadwal_periksa` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_periksa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pasien_daftar_poli` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD CONSTRAINT `fk_detail_periksa` FOREIGN KEY (`id_periksa`) REFERENCES `periksa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detail_periksa_obat` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dokter`
--
ALTER TABLE `dokter`
  ADD CONSTRAINT `fk_dokter_poli` FOREIGN KEY (`id_poli`) REFERENCES `poli` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD CONSTRAINT `fk_dokter_jadwal_periksa` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `periksa`
--
ALTER TABLE `periksa`
  ADD CONSTRAINT `fk_periksa_daftar_poli` FOREIGN KEY (`id_daftar_poli`) REFERENCES `daftar_poli` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
