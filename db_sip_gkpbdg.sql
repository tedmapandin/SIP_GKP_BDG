-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2019 at 02:13 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sip_gkpbdg`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bidang`
--

CREATE TABLE `tbl_bidang` (
  `bid_id` int(2) NOT NULL,
  `bid_nama` varchar(50) NOT NULL,
  `bid_desc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_bidang`
--

INSERT INTO `tbl_bidang` (`bid_id`, `bid_nama`, `bid_desc`) VALUES
(1, 'PH', 'Pengurus Harian'),
(2, 'I. Peribadahan', 'Bidang Peribadahan'),
(3, 'II. Keesaan dan Kesaksian', 'Bidang Keesaan dan Kesaksian'),
(4, 'III. Pembinaan dan Pengembangan', 'Bidang Pembinaan dan Pengembangan'),
(5, 'IV. Sarana dan Prasarana', 'Bidang Sarana dan Prasarana');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bulan`
--

CREATE TABLE `tbl_bulan` (
  `bln_id` int(2) NOT NULL,
  `bln_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_bulan`
--

INSERT INTO `tbl_bulan` (`bln_id`, `bln_name`) VALUES
(1, 'Januari'),
(2, 'Febuari'),
(3, 'Maret'),
(4, 'April'),
(5, 'Mei'),
(6, 'Juni'),
(7, 'Juli'),
(8, 'Agustus'),
(9, 'September'),
(10, 'Oktober'),
(11, 'November'),
(12, 'Desember');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detkeg`
--

CREATE TABLE `tbl_detkeg` (
  `trans_id` int(7) NOT NULL,
  `detkeg_id` int(7) NOT NULL,
  `bln_id` int(2) NOT NULL,
  `thn_desc` int(4) NOT NULL,
  `detkeg_nama` varchar(100) NOT NULL,
  `detkeg_jenis` varchar(200) NOT NULL,
  `detkeg_urai` text NOT NULL,
  `detkeg_ket` text,
  `detkeg_tgl` date NOT NULL,
  `detkeg_tempat` varchar(100) NOT NULL,
  `detkeg_stat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_detkeg`
--

INSERT INTO `tbl_detkeg` (`trans_id`, `detkeg_id`, `bln_id`, `thn_desc`, `detkeg_nama`, `detkeg_jenis`, `detkeg_urai`, `detkeg_ket`, `detkeg_tgl`, `detkeg_tempat`, `detkeg_stat`) VALUES
(10, 12, 11, 2018, 'Seminar Memasak', '', 'Seminar Memasak', 'Seminar Memasak', '2018-11-17', 'GSG GKP Bandung', 0),
(15, 17, 12, 2018, 'Perawatan Ruang Studio', '', 'Perawatan Ruang Studio', 'Perawatan Ruang Studio', '2018-12-01', 'Ruang Studio Pemuda', 0),
(16, 18, 11, 2018, 'Kebaktian', '', 'Kebaktian', 'Kebaktian', '2018-11-24', 'Ruang Tiranus', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detkeu`
--

CREATE TABLE `tbl_detkeu` (
  `detkeu_id` int(7) NOT NULL,
  `detkeg_id` int(7) NOT NULL,
  `detkeu_tgl_trans` date NOT NULL,
  `detkeu_desc` text NOT NULL,
  `detkeu_nom` decimal(13,2) NOT NULL,
  `detkeu_realisasi` decimal(13,2) DEFAULT NULL,
  `detkeu_bukti` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_detkeu`
--

INSERT INTO `tbl_detkeu` (`detkeu_id`, `detkeg_id`, `detkeu_tgl_trans`, `detkeu_desc`, `detkeu_nom`, `detkeu_realisasi`, `detkeu_bukti`) VALUES
(15, 12, '2018-11-17', 'Bayar Pembicara', '500000.00', '0.00', NULL),
(20, 17, '2018-12-01', 'Beli Alat Pembersih', '110000.00', '0.00', NULL),
(21, 18, '2018-11-24', 'Viatikum PF', '1000000.00', '0.00', NULL),
(22, 18, '2018-11-24', 'Konsumsi', '50000.00', '0.00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_divisi`
--

CREATE TABLE `tbl_divisi` (
  `div_id` int(2) NOT NULL,
  `ktgdiv_id` int(2) NOT NULL,
  `div_nama` varchar(50) NOT NULL,
  `div_desc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_divisi`
--

INSERT INTO `tbl_divisi` (`div_id`, `ktgdiv_id`, `div_nama`, `div_desc`) VALUES
(1, 1, 'Majelis Umum', 'Majelis Umum'),
(2, 1, 'Majelis Bidang', 'Majelis Bidang'),
(3, 2, 'Komisi Pelayanan Anak', 'Komisi Pelayanan Anak'),
(4, 2, 'Komisi Remaja', 'Komisi Remaja'),
(5, 2, 'Komisi Pemuda', 'Komisi Pemuda'),
(6, 2, 'Komisi Perempuan', 'Komisi Perempuan'),
(7, 2, 'Komisi Pria', 'Komisi Pria'),
(8, 2, 'KPS', 'Komisi Para Sepuh');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_images`
--

CREATE TABLE `tbl_images` (
  `img_id` int(11) NOT NULL,
  `img_name` varchar(255) NOT NULL,
  `img_thumb` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jabatan`
--

CREATE TABLE `tbl_jabatan` (
  `jab_id` int(2) NOT NULL,
  `jab_nama` varchar(25) NOT NULL,
  `jab_desc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_jabatan`
--

INSERT INTO `tbl_jabatan` (`jab_id`, `jab_nama`, `jab_desc`) VALUES
(1, 'Ketua ', 'Ketua Divisi'),
(2, 'Ketua II', 'Ketua II'),
(3, 'Sekertaris', 'Sekertaris Divisi'),
(4, 'Sekertaris II', 'Sekertaris II'),
(5, 'Bendahara I', 'Bendahara I'),
(6, 'Bendahara II', 'Bendahara II'),
(7, 'Koordinator', 'Koordinator Bidang'),
(8, 'Anggota', 'Anggota Bidang');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ktgdiv`
--

CREATE TABLE `tbl_ktgdiv` (
  `ktgdiv_id` int(2) NOT NULL,
  `ktgdiv_nama` varchar(15) NOT NULL,
  `ktgdiv_desc` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_ktgdiv`
--

INSERT INTO `tbl_ktgdiv` (`ktgdiv_id`, `ktgdiv_nama`, `ktgdiv_desc`) VALUES
(1, 'Majelis', 'Majelis Jemaat GKP Bandung'),
(2, 'Komisi', 'Komisi Pelayanan GKP Bandung'),
(3, 'Staf', 'Pegawai Kantor GKP Bandung');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ktgtrans`
--

CREATE TABLE `tbl_ktgtrans` (
  `ktgtrans_id` int(1) NOT NULL,
  `ktgtrans_nama` varchar(15) NOT NULL,
  `ktg_trans_desc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_ktgtrans`
--

INSERT INTO `tbl_ktgtrans` (`ktgtrans_id`, `ktgtrans_nama`, `ktg_trans_desc`) VALUES
(1, 'Kegiatan', 'Transaksi laporan kegiatan'),
(2, 'Keuangan', 'Transaksi laporan keuangan');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_nmrakun`
--

CREATE TABLE `tbl_nmrakun` (
  `nmrakun_id` int(3) NOT NULL,
  `nmrakun_nama` int(3) NOT NULL,
  `nmrakun_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role`
--

CREATE TABLE `tbl_role` (
  `role_id` int(2) NOT NULL,
  `role_nama` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_role`
--

INSERT INTO `tbl_role` (`role_id`, `role_nama`) VALUES
(1, 'Administrator'),
(2, 'Operator');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tahun`
--

CREATE TABLE `tbl_tahun` (
  `thn_id` int(3) NOT NULL,
  `thn_desc` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tahun`
--

INSERT INTO `tbl_tahun` (`thn_id`, `thn_desc`) VALUES
(1, 2016),
(2, 2017),
(3, 2018),
(4, 2019),
(5, 2020),
(6, 2021),
(7, 2022),
(8, 2023),
(9, 2024),
(10, 2025);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaksi`
--

CREATE TABLE `tbl_transaksi` (
  `trans_id` int(7) NOT NULL,
  `div_id` int(2) NOT NULL,
  `bid_id` int(2) NOT NULL,
  `usr_id` int(3) NOT NULL,
  `trans_tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_transaksi`
--

INSERT INTO `tbl_transaksi` (`trans_id`, `div_id`, `bid_id`, `usr_id`, `trans_tgl`) VALUES
(10, 6, 4, 3, '2018-12-06 06:49:33'),
(15, 5, 5, 2, '2018-12-06 07:14:35'),
(16, 5, 2, 1, '2018-12-12 06:43:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `usr_id` int(3) NOT NULL,
  `role_id` int(2) NOT NULL,
  `ktgdiv_id` int(2) NOT NULL,
  `div_id` int(2) DEFAULT NULL,
  `bid_id` int(2) DEFAULT NULL,
  `jab_id` int(2) DEFAULT NULL,
  `usr_nama` varchar(25) NOT NULL,
  `usr_pswd` varchar(100) NOT NULL,
  `usr_name_comp` varchar(50) NOT NULL,
  `usr_email` varchar(35) DEFAULT NULL,
  `usr_phone` varchar(15) DEFAULT NULL,
  `usr_stat` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`usr_id`, `role_id`, `ktgdiv_id`, `div_id`, `bid_id`, `jab_id`, `usr_nama`, `usr_pswd`, `usr_name_comp`, `usr_email`, `usr_phone`, `usr_stat`) VALUES
(1, 1, 2, 5, 1, 1, 'bayukm', '4e4dfe019d649091f230f1dcd5b17101', 'Bayu Kristiadhi Muliasetia', 'bayukristiadhimuliasetia@gmail.com', '081312345678', 1),
(2, 2, 2, 5, 1, 3, 'vica_r', '0f0a417287f7f0d73ce04e322fee2af2', 'Vica Rianti', 'vicarianti@gmail.com', '087812345678', 1),
(3, 2, 2, 6, 2, 7, 'cilla', '15ca86843d6964d922ac3910e5f6cfaa', 'Priscila Natasha', 'cilla@gmail.com', '085612345678', 1),
(13, 2, 2, 7, 5, 8, 'ferdi', '5fc6425c1f58df083f073e6fe9a9091a', 'Ferdian', 'ferdi@gmail.com', '08112345678', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_bidang`
--
ALTER TABLE `tbl_bidang`
  ADD PRIMARY KEY (`bid_id`);

--
-- Indexes for table `tbl_bulan`
--
ALTER TABLE `tbl_bulan`
  ADD PRIMARY KEY (`bln_id`);

--
-- Indexes for table `tbl_detkeg`
--
ALTER TABLE `tbl_detkeg`
  ADD PRIMARY KEY (`detkeg_id`),
  ADD KEY `idx_transid` (`trans_id`),
  ADD KEY `idx_bln` (`bln_id`),
  ADD KEY `idx_thn` (`thn_desc`);

--
-- Indexes for table `tbl_detkeu`
--
ALTER TABLE `tbl_detkeu`
  ADD PRIMARY KEY (`detkeu_id`),
  ADD KEY `idx_detkeg` (`detkeg_id`);

--
-- Indexes for table `tbl_divisi`
--
ALTER TABLE `tbl_divisi`
  ADD PRIMARY KEY (`div_id`),
  ADD KEY `ktgdiv_id` (`ktgdiv_id`);

--
-- Indexes for table `tbl_images`
--
ALTER TABLE `tbl_images`
  ADD PRIMARY KEY (`img_id`);

--
-- Indexes for table `tbl_jabatan`
--
ALTER TABLE `tbl_jabatan`
  ADD PRIMARY KEY (`jab_id`);

--
-- Indexes for table `tbl_ktgdiv`
--
ALTER TABLE `tbl_ktgdiv`
  ADD PRIMARY KEY (`ktgdiv_id`);

--
-- Indexes for table `tbl_ktgtrans`
--
ALTER TABLE `tbl_ktgtrans`
  ADD PRIMARY KEY (`ktgtrans_id`);

--
-- Indexes for table `tbl_nmrakun`
--
ALTER TABLE `tbl_nmrakun`
  ADD PRIMARY KEY (`nmrakun_id`),
  ADD UNIQUE KEY `nmrakun_nama` (`nmrakun_nama`);

--
-- Indexes for table `tbl_role`
--
ALTER TABLE `tbl_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `tbl_tahun`
--
ALTER TABLE `tbl_tahun`
  ADD PRIMARY KEY (`thn_id`),
  ADD KEY `thn_desc` (`thn_desc`);

--
-- Indexes for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  ADD PRIMARY KEY (`trans_id`),
  ADD KEY `div_id` (`div_id`),
  ADD KEY `bid_id` (`bid_id`),
  ADD KEY `usr_id` (`usr_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`usr_id`),
  ADD KEY `idx_role` (`role_id`),
  ADD KEY `idx_jab` (`jab_id`),
  ADD KEY `idx_ktgdiv` (`ktgdiv_id`),
  ADD KEY `idx_div_id` (`div_id`),
  ADD KEY `idx_bid` (`bid_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_bidang`
--
ALTER TABLE `tbl_bidang`
  MODIFY `bid_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_bulan`
--
ALTER TABLE `tbl_bulan`
  MODIFY `bln_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tbl_detkeg`
--
ALTER TABLE `tbl_detkeg`
  MODIFY `detkeg_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `tbl_detkeu`
--
ALTER TABLE `tbl_detkeu`
  MODIFY `detkeu_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `tbl_divisi`
--
ALTER TABLE `tbl_divisi`
  MODIFY `div_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_images`
--
ALTER TABLE `tbl_images`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_jabatan`
--
ALTER TABLE `tbl_jabatan`
  MODIFY `jab_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tbl_ktgdiv`
--
ALTER TABLE `tbl_ktgdiv`
  MODIFY `ktgdiv_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_ktgtrans`
--
ALTER TABLE `tbl_ktgtrans`
  MODIFY `ktgtrans_id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_nmrakun`
--
ALTER TABLE `tbl_nmrakun`
  MODIFY `nmrakun_id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_role`
--
ALTER TABLE `tbl_role`
  MODIFY `role_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_tahun`
--
ALTER TABLE `tbl_tahun`
  MODIFY `thn_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  MODIFY `trans_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `usr_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_detkeg`
--
ALTER TABLE `tbl_detkeg`
  ADD CONSTRAINT `fk_detkeg_bln` FOREIGN KEY (`bln_id`) REFERENCES `tbl_bulan` (`bln_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detkeg_thn` FOREIGN KEY (`thn_desc`) REFERENCES `tbl_tahun` (`thn_desc`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_detkeu`
--
ALTER TABLE `tbl_detkeu`
  ADD CONSTRAINT `fk_detkeu_detkeg` FOREIGN KEY (`detkeg_id`) REFERENCES `tbl_detkeg` (`detkeg_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_divisi`
--
ALTER TABLE `tbl_divisi`
  ADD CONSTRAINT `fk_div_ktgdiv` FOREIGN KEY (`ktgdiv_id`) REFERENCES `tbl_ktgdiv` (`ktgdiv_id`);

--
-- Constraints for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  ADD CONSTRAINT `fk_trans_bid` FOREIGN KEY (`bid_id`) REFERENCES `tbl_bidang` (`bid_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_trans_div` FOREIGN KEY (`div_id`) REFERENCES `tbl_divisi` (`div_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_trans_usr` FOREIGN KEY (`usr_id`) REFERENCES `tbl_user` (`usr_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `fk_usr_bid` FOREIGN KEY (`bid_id`) REFERENCES `tbl_bidang` (`bid_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usr_div` FOREIGN KEY (`div_id`) REFERENCES `tbl_divisi` (`div_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usr_jab` FOREIGN KEY (`jab_id`) REFERENCES `tbl_jabatan` (`jab_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usr_ktgdiv` FOREIGN KEY (`ktgdiv_id`) REFERENCES `tbl_ktgdiv` (`ktgdiv_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usr_role` FOREIGN KEY (`role_id`) REFERENCES `tbl_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
