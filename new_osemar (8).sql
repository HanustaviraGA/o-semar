-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2021 at 06:41 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new_osemar`
--

-- --------------------------------------------------------

--
-- Table structure for table `jenis_surat`
--

CREATE TABLE `jenis_surat` (
  `id` int(11) NOT NULL,
  `jenis` varchar(300) NOT NULL,
  `keterangan_jenis` varchar(300) NOT NULL,
  `identifier` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis_surat`
--

INSERT INTO `jenis_surat` (`id`, `jenis`, `keterangan_jenis`, `identifier`) VALUES
(1, 'Surat Keterangan Penghasilan', 'Untuk memberikan keterangan bahwa penduduk telah bekerja dan memiliki penghasilan', 1),
(2, 'Surat Keterangan Pindah', 'Sebagai surat pengantar di tempat tujuan yang menerangkan mengenai asal domisili penduduk', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lampiran`
--

CREATE TABLE `lampiran` (
  `nik` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `kode` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `lampiran` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `jenis_lampiran` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `tanggal_lampiran` varchar(300) NOT NULL DEFAULT current_timestamp(),
  `status_lampiran` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `ket_lampiran` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lampiran`
--

INSERT INTO `lampiran` (`nik`, `kode`, `lampiran`, `jenis_lampiran`, `tanggal_lampiran`, `status_lampiran`, `ket_lampiran`) VALUES
('987456321', '2', '2_987456321.pdf', 'Pembayaran Tagihan', '2021-12-18', 'Paid', '-'),
('321654999', 'SRT61af1997e721a', '61af1997e7222_321654999.png', 'Pengajuan Surat', '2021-12-07', 'Pending', '-'),
('321654999', 'SRT61af1997e721a', '61af1997e8165_321654999.jpg', 'Pengajuan Surat', '2021-12-07', 'Pending', '-'),
('123456789', 'LPR61af1ceacf32d', '61af1ceacf336_123456789.jpg', 'Laporan Masyarakat', '2021-12-07', 'Pending', '-'),
('123456789', 'LPR61af1ceacf32d', '61af1cead2a92_123456789.png', 'Laporan Masyarakat', '2021-12-07', 'Pending', '-'),
('321654999', 'SRT61af46c62d2da', '61af46c62d2e3_321654999.png', 'Pengajuan Surat', '2021-12-07', 'Pending', '-'),
('321654999', 'SRT61af46c62d2da', '61af46c62e6b1_321654999.jpg', 'Pengajuan Surat', '2021-12-07', 'Pending', '-'),
('123456789', 'TGHN61b2228ee549c', '61b2228ee56a3_123456789.png', 'Pembayaran Tagihan', '2021-12-09', 'Unpaid', '-'),
('123456789', 'Tidak Diketahui', '61b5099b70d9b_123456789.png', 'Pengumuman Warga', '2021-12-11', 'Pending', '-'),
('123456789', 'SRT61b60297baa51', 'SRT61b60297baa51_123456789.pdf', 'Pembayaran Tagihan', '2021-12-13', 'Unpaid', '-'),
('123456789', 'SRT61bc7e8554a3c', 'SRT61bc7e8554a3c_123456789.pdf', 'Pembayaran Tagihan', '2021-12-17', 'Unpaid', '-'),
('123456789', 'SRT61bc8264282a5', 'SRT61bc8264282a5_123456789.pdf', 'Pembayaran Tagihan', '2021-12-17', 'Unpaid', '-'),
('987456321', 'TGHN61b2228ee549c', 'TGHN61b2228ee549c_123456789.pdf', 'Pembayaran Tagihan', '2021-12-13', 'Paid', '-');

-- --------------------------------------------------------

--
-- Table structure for table `msadmin`
--

CREATE TABLE `msadmin` (
  `nik` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `msadmin`
--

INSERT INTO `msadmin` (`nik`) VALUES
('123456789');

-- --------------------------------------------------------

--
-- Table structure for table `mskabkota`
--

CREATE TABLE `mskabkota` (
  `id_kabkota` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `id_provinsi` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `nama_kabkota` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mskabkota`
--

INSERT INTO `mskabkota` (`id_kabkota`, `id_provinsi`, `nama_kabkota`) VALUES
('07', '35', 'Kabupaten Malang');

-- --------------------------------------------------------

--
-- Table structure for table `mskecamatan`
--

CREATE TABLE `mskecamatan` (
  `id_kecamatan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `id_kabkota` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `nama_kecamatan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mskecamatan`
--

INSERT INTO `mskecamatan` (`id_kecamatan`, `id_kabkota`, `nama_kecamatan`) VALUES
('24', '07', 'Singosari');

-- --------------------------------------------------------

--
-- Table structure for table `mskelurahan`
--

CREATE TABLE `mskelurahan` (
  `id_kelurahan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `id_kecamatan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `nama_kelurahan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mskelurahan`
--

INSERT INTO `mskelurahan` (`id_kelurahan`, `id_kecamatan`, `nama_kelurahan`) VALUES
('2013', '24', 'Desa Ardimulyo');

-- --------------------------------------------------------

--
-- Table structure for table `msprovinsi`
--

CREATE TABLE `msprovinsi` (
  `id_provinsi` varchar(300) NOT NULL,
  `nama_provinsi` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `msprovinsi`
--

INSERT INTO `msprovinsi` (`id_provinsi`, `nama_provinsi`) VALUES
('33', 'Jawa Tengah'),
('35', 'Jawa Timur');

-- --------------------------------------------------------

--
-- Table structure for table `msrt`
--

CREATE TABLE `msrt` (
  `id_rt` varchar(300) NOT NULL,
  `id_rw` varchar(300) NOT NULL,
  `nik_ketuart` varchar(300) NOT NULL,
  `nama_rt` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `msrt`
--

INSERT INTO `msrt` (`id_rt`, `id_rw`, `nik_ketuart`, `nama_rt`) VALUES
('4', '8', '456789123', 'Cheryl Almeira'),
('5', '8', '12345678900', 'Zulkifli');

-- --------------------------------------------------------

--
-- Table structure for table `msrw`
--

CREATE TABLE `msrw` (
  `id_rw` varchar(300) NOT NULL,
  `id_kelurahan` varchar(300) NOT NULL,
  `nik_ketuarw` varchar(300) NOT NULL,
  `nama_rw` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `msrw`
--

INSERT INTO `msrw` (`id_rw`, `id_kelurahan`, `nik_ketuarw`, `nama_rw`) VALUES
('8', '2013', '987456321', 'Andru Baskara Putra'),
('9', '2013', '66974215', 'Setyo');

-- --------------------------------------------------------

--
-- Table structure for table `mssettings`
--

CREATE TABLE `mssettings` (
  `identifier` int(1) NOT NULL,
  `id_provinsi` varchar(300) NOT NULL,
  `nama_provinsi` varchar(300) NOT NULL,
  `id_kabkota` varchar(300) NOT NULL,
  `nama_kabkota` varchar(300) NOT NULL,
  `id_kecamatan` varchar(300) NOT NULL,
  `nama_kecamatan` varchar(300) NOT NULL,
  `id_kelurahan` varchar(300) NOT NULL,
  `nama_kelurahan` varchar(300) NOT NULL,
  `kode_pos` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mssettings`
--

INSERT INTO `mssettings` (`identifier`, `id_provinsi`, `nama_provinsi`, `id_kabkota`, `nama_kabkota`, `id_kecamatan`, `nama_kecamatan`, `id_kelurahan`, `nama_kelurahan`, `kode_pos`) VALUES
(1, '35', 'Jawa Timur', '07', 'Kabupaten Malang', '24', 'Singosari', '2013', 'Desa Ardimulyo', '65153');

-- --------------------------------------------------------

--
-- Table structure for table `pelaporan`
--

CREATE TABLE `pelaporan` (
  `id_pelaporan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `nik` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `id_rt` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `id_rw` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `kategori` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `keterangan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `tanggal_pelaporan` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `alasan` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelaporan`
--

INSERT INTO `pelaporan` (`id_pelaporan`, `nik`, `id_rt`, `id_rw`, `kategori`, `keterangan`, `tanggal_pelaporan`, `status`, `alasan`) VALUES
('LPR61af1ceacf32d', '123456789', '4', '8', 'Tata Tertib', 'Mohon agar segera ditindaklanjuti', '2021-12-07', 'Pending', '');

-- --------------------------------------------------------

--
-- Table structure for table `penduduk`
--

CREATE TABLE `penduduk` (
  `no_kk` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `nik` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `nama` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `tempat_lahir` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `tanggal_lahir` date NOT NULL DEFAULT current_timestamp(),
  `alamat` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `id_rt` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `id_rw` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `jenis_kelamin` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `agama` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `status_perkawinan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `pekerjaan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `gol_darah` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `kewarganegaraan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `status_ktp` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `foto_ktp` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `email` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `username` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `password` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `no_hp` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `status_hubungan_keluarga` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `no_paspor` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `no_kitas` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `kepala_keluarga` int(1) NOT NULL DEFAULT 0,
  `nama_ayah` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `nama_ibu` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `virtual_account_id` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `foto_kk` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `pendidikan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `tanggal_pengeluaran_kk` date NOT NULL DEFAULT current_timestamp(),
  `tanggal_reg` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penduduk`
--

INSERT INTO `penduduk` (`no_kk`, `nik`, `nama`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `id_rt`, `id_rw`, `jenis_kelamin`, `agama`, `status_perkawinan`, `pekerjaan`, `gol_darah`, `kewarganegaraan`, `status_ktp`, `foto_ktp`, `email`, `username`, `password`, `no_hp`, `status_hubungan_keluarga`, `no_paspor`, `no_kitas`, `kepala_keluarga`, `nama_ayah`, `nama_ibu`, `virtual_account_id`, `foto_kk`, `pendidikan`, `tanggal_pengeluaran_kk`, `tanggal_reg`) VALUES
('4623241', '0087964', 'Albertus', 'Tidak Diketahui', '2021-12-08', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'albertus@binus.ac.id', 'albertus', 'buwinajoss', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 0, 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', '2021-12-08', '2021-12-08'),
('999777444', '123456789', 'Hanustavira Guru Acarya', '', '0000-00-00', '', '4', '8', '', '', '', '', '', '', '', '', 'hanvir@sunib.com', 'hanhan', '$2y$10$O9sKO0J2qPhuIifqHrZeQuXFE531.sRjafE2SHD0yDh31lYKRKRPy', '', '', '', '', 1, '', '', '', 'KK_12345678.jpg', '', '2021-12-01', '0000-00-00'),
('12345678900', '12345678900', 'Zulkifli', 'Tidak Diketahui', '2021-12-11', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'zulkifli@binus.ac.id', 'zulkifli', '$2y$10$Yz.XN0egTQdp6KFBcDK31u1vo.7YqsszKZJHa1r/tI5FoCQ6jvM9K', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 0, 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', '2021-12-11', '2021-12-11'),
('123888', '222333666', 'Budiman', 'Surabaya', '0000-00-00', '', '4', '8', '', '', '', '', '', '', '', '', '', '', 'sunibngalam', '', '', '', '', 1, '', '', '', '', '', '2021-12-01', '0000-00-00'),
('333', '321654987', 'Michelle Angela Guntjoro', '', '2001-06-27', '', '5', '8', '', '', '', '', '', '', '', '', '', 'cele', '$2y$10$O9sKO0J2qPhuIifqHrZeQuXFE531.sRjafE2SHD0yDh31lYKRKRPy', '', '', '', '', 1, '', '', '', '', '', '2021-12-01', '0000-00-00'),
('667452', '321654999', 'Siswanto', 'Tidak Diketahui', '2021-12-11', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'siswanto@binus.ac.id', 'siswanto', '$2y$10$7LUf9P0AI9NoRHIe4mFcTuN5GYOKBqmUktmgL.CesMg6e/79dVmxi', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 0, 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', '2021-12-11', '2021-12-11'),
('12345678', '3534342493434', 'Luki', 'Tidak Diketahui', '2021-11-16', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'muhammad.masyhuri@binus.ac.id', 'fikri', 'sunibngalam', 'Tidak Diketahui', '', '', '', 0, 'Hendra', 'Sri', '', '', '', '2021-12-01', '2021-11-16'),
('12345678', '3534342493436', 'Sumartono', 'Tidak Diketahui', '2021-11-16', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'muhammad.masyhuri@binus.ac.id', 'fikris', 'sunibngalam', 'Tidak Diketahui', '', '', '', 0, 'Sugiyanto', 'Dewi', '', '', '', '2021-12-01', '2021-11-16'),
('35794523974461', '35794510335481', 'Sanusi', 'Tidak Diketahui', '2021-11-16', 'Tidak Diketahui', '4', '9', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'dhani@binus.ac.id', 'dhani', 'sunibngalam', 'Tidak Diketahui', '', '', '', 1, '', '', '', '', '', '2021-12-01', '2021-11-16'),
('4479674', '3741520', 'Suhartini', 'Tidak Diketahui', '2021-12-08', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'suhartini@binus.ac.id', 'suhartini', 'sunibngalam', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 0, 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', '2021-12-08', '2021-12-08'),
('4479652', '3741554', 'Dionisius', 'Tidak Diketahui', '2021-12-08', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'dionisius@binus.ac.id', 'dion', 'sunibngalam', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 0, 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', '2021-12-08', '2021-12-08'),
('897', '456789123', 'Cheryl Almeira', '', '2021-10-27', '', '4', '8', '', '', '', '', '', '', '', '', '', 'cheryl', '$2y$10$O9sKO0J2qPhuIifqHrZeQuXFE531.sRjafE2SHD0yDh31lYKRKRPy', '', '', '', '', 1, '', '', '', '', '', '2021-12-01', '0000-00-00'),
('2251484774424', '6488254872334', 'Surip', 'Tidak Diketahui', '2021-11-16', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'suherman@binus.ac.id', 'suherman', 'sunibngalam', 'Tidak Diketahui', '', '', '', 0, '', '', '', '', '', '2021-12-01', '2021-11-16'),
('2251484774500', '6488254872501', 'Sudarmono', 'Tidak Diketahui', '0000-00-00', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'sudarmono@binus.ac.id', 'sudarmono', 'sunibngalam', 'Tidak Diketahui', '', '', '', 0, '', '', '', '', '', '2021-12-01', '2021-11-16'),
('554', '654987321', 'Gerry Guinardi', '', '0000-00-00', '', '4', '8', '', '', '', '', '', '', '', '', '', 'overlord', 'sunibngalam', '', '', '', '', 0, '', '', '', '', '', '2021-12-01', '0000-00-00'),
('35679524', '66974215', 'Setyo', 'Tidak Diketahui', '2021-12-10', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'setyo@binus.ac.id', 'setyo', '$2y$10$O9sKO0J2qPhuIifqHrZeQuXFE531.sRjafE2SHD0yDh31lYKRKRPy', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 0, 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', '2021-12-10', '2021-12-10'),
('22561174', '77925411', 'Dian', 'Tidak Diketahui', '2021-12-08', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'dian@binus.ac.id', 'dian', 'sunibngalam', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 0, 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', '2021-12-08', '2021-12-08'),
('22561178', '77925421', 'Bimo', 'Tidak Diketahui', '2021-12-10', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'bimo@binus.ac.id', 'bimo', 'sunibngalam', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 0, 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', '2021-12-10', '2021-12-10'),
('1234567890', '92919010293', 'Fikri Imaduddin', 'Tidak Diketahui', '2021-12-06', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'fikri.iaim@gmail.com', 'fikcoy', 'sunibngalam', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 0, 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', '2021-12-06', '2021-12-06'),
('664', '987456321', 'Andru Baskara Putra', '', '0000-00-00', '', '3', '8', '', '', '', '', '', '', '', '', '', 'andru', '$2y$10$O9sKO0J2qPhuIifqHrZeQuXFE531.sRjafE2SHD0yDh31lYKRKRPy', '', '', '', '', 0, '', '', '', '', '', '2021-12-01', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `pengumuman` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `isi` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `id_rt` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `id_rw` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `pengirim` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `pengumuman`, `isi`, `tanggal`, `id_rt`, `id_rw`, `pengirim`) VALUES
('A975541', 'Penertiban Parkir Liar Warga', 'Dimohon bagi warga RT 4 RW 8 untuk tidak memarkirkan kendaraannya di tepi jalan umum.', '2021-12-04', '5', '8', 'Kepala RW 8 - Andru Baskara Putra'),
('PNG61b5099b70d8e', 'Himbauan Masyarakat', 'Berjaga jaga dengan COVID-19', '2021-12-11', '4', '8', 'Hanustavira Guru Acarya');

-- --------------------------------------------------------

--
-- Table structure for table `suratketerangan`
--

CREATE TABLE `suratketerangan` (
  `no_surat` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `nik` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `id_rt` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `id_rw` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `jenis` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `keperluan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `tanggal_pengajuan` date NOT NULL DEFAULT current_timestamp(),
  `keterangan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `status` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `alasan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suratketerangan`
--

INSERT INTO `suratketerangan` (`no_surat`, `nik`, `id_rt`, `id_rw`, `jenis`, `keperluan`, `tanggal_pengajuan`, `keterangan`, `status`, `alasan`) VALUES
('A98EDB', '123456789', '4', '8', '', 'Pengurusan Izin Usaha', '2021-10-13', 'Dibutuhkan mendesak', 'Terverifikasi', ''),
('SRT61af1997e721a', '321654999', '4', '8', 'Surat Keterangan Belum Menikah', 'Pengurusan Surat Kerja', '2021-12-07', 'Dibutuhkan Mendesak', 'Pending', '-'),
('SRT61af46c62d2da', '321654999', '4', '8', 'Surat Keterangan Penghasilan', 'Pengurusan Beasiswa', '2021-12-07', 'Dibutuhkan Mendesak', 'Pending', '-');

-- --------------------------------------------------------

--
-- Table structure for table `tagihan`
--

CREATE TABLE `tagihan` (
  `id_tagihan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `nik` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `id_rt` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `id_rw` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `jenis_tagihan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `total_tagihan` int(255) NOT NULL DEFAULT 0,
  `jatuh_tempo` date NOT NULL DEFAULT current_timestamp(),
  `status_pembayaran` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `rekening` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `bukti_pembayaran` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `tanggal_pembayaran` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tagihan`
--

INSERT INTO `tagihan` (`id_tagihan`, `nik`, `id_rt`, `id_rw`, `jenis_tagihan`, `total_tagihan`, `jatuh_tempo`, `status_pembayaran`, `rekening`, `bukti_pembayaran`, `tanggal_pembayaran`) VALUES
('2', '987456321', '4', '8', 'Kebersihan', 100000, '2021-10-17', 'Paid', '555555', 'null', '2021-10-18'),
('SRT61b60297baa51', '123456789', '4', '8', 'Bayar Parkir', 150000, '2021-12-31', 'Unpaid', '00039147791', '-', '0000-00-00'),
('SRT61baf13fc92fd', '123456789', '4', '8', 'Bayar Parkir', 150000, '2021-12-16', 'Unpaid', 'BCA : 1234567', '-', '0000-00-00'),
('SRT61bc7e8554a3c', '123456789', '4', '8', 'Uang Keamanan', 50000, '2021-12-29', 'Unpaid', 'BCA : 1234567', '-', '0000-00-00'),
('SRT61bc8264282a5', '123456789', '4', '8', 'Bayar Keamanan dan Ketertiban', 150000, '2021-12-23', 'Unpaid', '00039147791', '-', '0000-00-00'),
('SRT61bd6a1a81410', '123456789', '4', '8', '', 1000, '2021-12-20', 'Unpaid', '111111111111', '-', '0000-00-00'),
('TGHN61b2228ee549c', '123456789', '4', '8', 'Keamanan', 500000, '2021-10-01', 'Paid', '444444', '61b2228ee56a3_123456789.png', '2021-10-07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jenis_surat`
--
ALTER TABLE `jenis_surat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lampiran`
--
ALTER TABLE `lampiran`
  ADD PRIMARY KEY (`lampiran`);

--
-- Indexes for table `msadmin`
--
ALTER TABLE `msadmin`
  ADD PRIMARY KEY (`nik`);

--
-- Indexes for table `mskabkota`
--
ALTER TABLE `mskabkota`
  ADD PRIMARY KEY (`id_kabkota`);

--
-- Indexes for table `mskecamatan`
--
ALTER TABLE `mskecamatan`
  ADD PRIMARY KEY (`id_kecamatan`);

--
-- Indexes for table `mskelurahan`
--
ALTER TABLE `mskelurahan`
  ADD PRIMARY KEY (`id_kelurahan`);

--
-- Indexes for table `msprovinsi`
--
ALTER TABLE `msprovinsi`
  ADD PRIMARY KEY (`id_provinsi`);

--
-- Indexes for table `msrt`
--
ALTER TABLE `msrt`
  ADD PRIMARY KEY (`id_rt`);

--
-- Indexes for table `msrw`
--
ALTER TABLE `msrw`
  ADD PRIMARY KEY (`id_rw`);

--
-- Indexes for table `mssettings`
--
ALTER TABLE `mssettings`
  ADD PRIMARY KEY (`identifier`);

--
-- Indexes for table `pelaporan`
--
ALTER TABLE `pelaporan`
  ADD PRIMARY KEY (`id_pelaporan`);

--
-- Indexes for table `penduduk`
--
ALTER TABLE `penduduk`
  ADD PRIMARY KEY (`nik`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suratketerangan`
--
ALTER TABLE `suratketerangan`
  ADD PRIMARY KEY (`no_surat`);

--
-- Indexes for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id_tagihan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
