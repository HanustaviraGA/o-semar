-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Jan 2022 pada 07.51
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.1.1

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
-- Struktur dari tabel `jenis_surat`
--

CREATE TABLE `jenis_surat` (
  `id` int(11) NOT NULL,
  `jenis` varchar(300) NOT NULL,
  `keterangan_jenis` varchar(300) NOT NULL,
  `daftar_lampiran` varchar(300) NOT NULL,
  `identifier` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jenis_surat`
--

INSERT INTO `jenis_surat` (`id`, `jenis`, `keterangan_jenis`, `daftar_lampiran`, `identifier`) VALUES
(1, 'Surat Keterangan Penghasilan', 'Untuk memberikan keterangan bahwa penduduk telah bekerja dan memiliki penghasilan', 'REKENING KORAN, STRUK GAJI TERAKHIR', 1),
(2, 'Surat Keterangan Pindah Masuk', 'Sebagai surat pengantar di tempat tujuan yang menerangkan mengenai asal domisili penduduk', 'SURAT KETERANGAN DOMISILI, FOTOCOPY KTP, SKCK', 1),
(3, 'Surat Keterangan Akte Kelahiran', 'Surat pengantar dalam proses pembuatan Akte Kelahiran', 'FOTOCOPY KTP ORANG TUA, FOTOCOPY BUKU NIKAH', 1),
(4, 'Surat Keterangan Akte Kematian', 'Surat yang berguna dalam proses pembuatan akte kematian', 'FOTOCOPY SERTIFIKAT KEMATIAN DARI RS', 1),
(5, 'Surat Keterangan Pindah Keluar', 'Surat yang menerangkan mengenai warga yang hendak keluar dari domisilinya', 'FOTOCOPY KTP', 1),
(6, 'Surat Keterangan Akan Menikah', 'Surat yang berguna dalam proses pembuatan pencatatan pernikah di KUA', 'FOTOCOPY KTP, FOTOCOPY SURAT KETERANGAN BELUM MENIKAH', 1),
(7, 'Surat Keterangan Ahli Waris', 'Surat yang berguna dalam penentuan ahli waris dari suatu objek harta', 'FOTOCOPY KTP AHLI WARIS, FOTO OBJEK HARTA WARISAN', 1),
(8, 'Surat Keterangan Domisili', 'Surat keterangan yang menerangkan warga yang saat ini sedang berada di luar domisilinya', 'FOTOCOPY KTP, SKCK', 1),
(9, 'Surat Keterangan Akan Bercerai', 'Surat keterangan yang menerangkan warga yang akan bercerai di KUA', 'FOTOCOPY KTP, FOTOCOPY BUKU NIKAH', 1),
(10, 'Surat Keterangan KTP', 'Surat keterangan yang berguna dalam proses penerbitan KTP di Dispendukcapil', 'FOTOCOPY KK, FOTOCOPY AKTE KELAHIRAN', 1),
(11, 'Surat Keterangan Kartu Keluarga', 'Surat yang berguna dalam proses pembuatan Kartu Keluarga di Dispendukcapil', 'FOTOCOPY SURAT KETERANGAN DOMISILI', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `lampiran`
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
-- Dumping data untuk tabel `lampiran`
--

INSERT INTO `lampiran` (`nik`, `kode`, `lampiran`, `jenis_lampiran`, `tanggal_lampiran`, `status_lampiran`, `ket_lampiran`) VALUES
('321654987', 'SRT61f2592130e18', '61f2592130e25_321654987.png', 'Pengajuan Surat', '2022-01-27', 'Telah Diperiksa', ''),
('321654987', 'SRT61f2592130e18', '61f2592131f02_321654987.png', 'Pengajuan Surat', '2022-01-27', 'Telah Diperiksa', ''),
('321654987', 'LPR61f32ed6e7caa', '61f32ed6e7cb2_321654987.jpg', 'Laporan Masyarakat', '2022-01-28', 'Pending', '-'),
('321654987', 'LPR61f32ed6e7caa', '61f32ed6e9cfe_321654987.jpg', 'Laporan Masyarakat', '2022-01-28', 'Pending', '-'),
('321654987', 'TGHN61f329af94a17', '61f3d0204116f_321654987.jpg', 'Pembayaran Tagihan', '2022-01-28', 'Telah Diperiksa', 'Paid'),
('123456789', 'PNG61f338c370c6e', 'PNG61f338c370c6e_123456789.jpg', 'Pengumuman Warga', '2022-01-28', '-', '-'),
('321654987', 'SRT61f2592130e18', 'SRT61f2592130e18_321654987.pdf', 'Pengajuan Surat', '2022-01-28', 'Telah Diperiksa', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `msadmin`
--

CREATE TABLE `msadmin` (
  `nik` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `msadmin`
--

INSERT INTO `msadmin` (`nik`) VALUES
('123456789');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mskabkota`
--

CREATE TABLE `mskabkota` (
  `id_kabkota` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `id_provinsi` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `nama_kabkota` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `mskabkota`
--

INSERT INTO `mskabkota` (`id_kabkota`, `id_provinsi`, `nama_kabkota`) VALUES
('07', '35', 'Kabupaten Malang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mskecamatan`
--

CREATE TABLE `mskecamatan` (
  `id_kecamatan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `id_kabkota` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `nama_kecamatan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `mskecamatan`
--

INSERT INTO `mskecamatan` (`id_kecamatan`, `id_kabkota`, `nama_kecamatan`) VALUES
('24', '07', 'Singosari');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mskelurahan`
--

CREATE TABLE `mskelurahan` (
  `id_kelurahan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `id_kecamatan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `nama_kelurahan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `mskelurahan`
--

INSERT INTO `mskelurahan` (`id_kelurahan`, `id_kecamatan`, `nama_kelurahan`) VALUES
('2013', '24', 'Desa Ardimulyo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `msprovinsi`
--

CREATE TABLE `msprovinsi` (
  `id_provinsi` varchar(300) NOT NULL,
  `nama_provinsi` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `msprovinsi`
--

INSERT INTO `msprovinsi` (`id_provinsi`, `nama_provinsi`) VALUES
('33', 'Jawa Tengah'),
('35', 'Jawa Timur');

-- --------------------------------------------------------

--
-- Struktur dari tabel `msrt`
--

CREATE TABLE `msrt` (
  `id_rt` varchar(300) NOT NULL,
  `id_rw` varchar(300) NOT NULL,
  `nik_ketuart` varchar(300) NOT NULL,
  `nama_rt` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `msrt`
--

INSERT INTO `msrt` (`id_rt`, `id_rw`, `nik_ketuart`, `nama_rt`) VALUES
('1', '9', '3741554', 'Dionisius'),
('4', '8', '456789123', 'Cheryl Almeira'),
('5', '8', '12345678900', 'Zulkifli'),
('6', '8', '3741520', 'Suhartini'),
('7', '8', '3534342493434', 'Luki');

-- --------------------------------------------------------

--
-- Struktur dari tabel `msrw`
--

CREATE TABLE `msrw` (
  `id_rw` varchar(300) NOT NULL,
  `id_kelurahan` varchar(300) NOT NULL,
  `nik_ketuarw` varchar(300) NOT NULL,
  `nama_rw` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `msrw`
--

INSERT INTO `msrw` (`id_rw`, `id_kelurahan`, `nik_ketuarw`, `nama_rw`) VALUES
('10', '2013', '6488254872501', 'Sudarmono'),
('8', '2013', '987456321', 'Andru Baskara Putra'),
('9', '2013', '66974215', 'Setyo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mssettings`
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
-- Dumping data untuk tabel `mssettings`
--

INSERT INTO `mssettings` (`identifier`, `id_provinsi`, `nama_provinsi`, `id_kabkota`, `nama_kabkota`, `id_kecamatan`, `nama_kecamatan`, `id_kelurahan`, `nama_kelurahan`, `kode_pos`) VALUES
(1, '35', 'Jawa Timur', '07', 'Kabupaten Malang', '24', 'Singosari', '2013', 'Desa Ardimulyo', '65153');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelaporan`
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
-- Dumping data untuk tabel `pelaporan`
--

INSERT INTO `pelaporan` (`id_pelaporan`, `nik`, `id_rt`, `id_rw`, `kategori`, `keterangan`, `tanggal_pelaporan`, `status`, `alasan`) VALUES
('LPR61f32ed6e7caa', '321654987', '5', '8', 'Sarana dan Prasarana', 'Hadir ', '2022-01-28', 'Pending', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penduduk`
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
-- Dumping data untuk tabel `penduduk`
--

INSERT INTO `penduduk` (`no_kk`, `nik`, `nama`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `id_rt`, `id_rw`, `jenis_kelamin`, `agama`, `status_perkawinan`, `pekerjaan`, `gol_darah`, `kewarganegaraan`, `status_ktp`, `foto_ktp`, `email`, `username`, `password`, `no_hp`, `status_hubungan_keluarga`, `no_paspor`, `no_kitas`, `kepala_keluarga`, `nama_ayah`, `nama_ibu`, `virtual_account_id`, `foto_kk`, `pendidikan`, `tanggal_pengeluaran_kk`, `tanggal_reg`) VALUES
('4623241', '0087964', 'Albertus', 'Tidak Diketahui', '2021-12-08', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'albertus@binus.ac.id', 'albertus', 'buwinajoss', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 0, 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', '2021-12-08', '2021-12-08'),
('999777444', '123456789', 'Hanustavira Guru Acarya', 'Malang', '2000-03-27', 'Dusun Karangjati', '4', '8', 'Laki - Laki', 'Islam', 'Belum Kawin', 'Mahasiswa', '', 'WNI', '', '', 'hanvir@sunib.com', 'hanhan', '$2y$10$O9sKO0J2qPhuIifqHrZeQuXFE531.sRjafE2SHD0yDh31lYKRKRPy', '', '', '', '', 1, '', '', '', 'KK_12345678.jpg', '', '2021-12-01', '0000-00-00'),
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
('47281983129479', '47248500172323', 'Misnari', 'Tidak Diketahui', '2022-01-17', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'misnari@binus.ac.id', 'misnari', '$2y$10$4TXahJROwhEFwfpUdn/Q/OXVSPfRgDcXtI/xbKvUtXXdRGgUQT5Pm', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 0, 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', '2022-01-17', '2022-01-17'),
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
-- Struktur dari tabel `pengumuman`
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
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `pengumuman`, `isi`, `tanggal`, `id_rt`, `id_rw`, `pengirim`) VALUES
('PNG61f338c370c6e', 'Bayar Keamanan dan Ketertiban', 'Hati hati ada hajatan', '2022-01-28', '4', '8', 'Hanustavira Guru Acarya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `suratketerangan`
--

CREATE TABLE `suratketerangan` (
  `no_surat` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `nik` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `id_rt` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `id_rw` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `jenis` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `keperluan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `tanggal_pengajuan` date NOT NULL DEFAULT current_timestamp(),
  `tujuan` varchar(300) NOT NULL,
  `keterangan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `status` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `alasan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `suratketerangan`
--

INSERT INTO `suratketerangan` (`no_surat`, `nik`, `id_rt`, `id_rw`, `jenis`, `keperluan`, `tanggal_pengajuan`, `tujuan`, `keterangan`, `status`, `alasan`) VALUES
('SRT61f2592130e18', '321654987', '5', '8', 'Surat Keterangan Penghasilan', 'Keberangkatan ke luar negeri', '2022-01-27', 'Mancing di sawah', 'Hadir', 'Terverifikasi', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tagihan`
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
-- Dumping data untuk tabel `tagihan`
--

INSERT INTO `tagihan` (`id_tagihan`, `nik`, `id_rt`, `id_rw`, `jenis_tagihan`, `total_tagihan`, `jatuh_tempo`, `status_pembayaran`, `rekening`, `bukti_pembayaran`, `tanggal_pembayaran`) VALUES
('TGHN61f329af94a17', '321654987', '5', '8', 'Bayar Tagihan Air', 153000, '2022-01-31', 'Paid', 'BCA : 1234567', '61f3d0204116f_321654987.jpg', '2022-01-28');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jenis_surat`
--
ALTER TABLE `jenis_surat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lampiran`
--
ALTER TABLE `lampiran`
  ADD PRIMARY KEY (`lampiran`);

--
-- Indeks untuk tabel `msadmin`
--
ALTER TABLE `msadmin`
  ADD PRIMARY KEY (`nik`);

--
-- Indeks untuk tabel `mskabkota`
--
ALTER TABLE `mskabkota`
  ADD PRIMARY KEY (`id_kabkota`);

--
-- Indeks untuk tabel `mskecamatan`
--
ALTER TABLE `mskecamatan`
  ADD PRIMARY KEY (`id_kecamatan`);

--
-- Indeks untuk tabel `mskelurahan`
--
ALTER TABLE `mskelurahan`
  ADD PRIMARY KEY (`id_kelurahan`);

--
-- Indeks untuk tabel `msprovinsi`
--
ALTER TABLE `msprovinsi`
  ADD PRIMARY KEY (`id_provinsi`);

--
-- Indeks untuk tabel `msrt`
--
ALTER TABLE `msrt`
  ADD PRIMARY KEY (`id_rt`);

--
-- Indeks untuk tabel `msrw`
--
ALTER TABLE `msrw`
  ADD PRIMARY KEY (`id_rw`);

--
-- Indeks untuk tabel `mssettings`
--
ALTER TABLE `mssettings`
  ADD PRIMARY KEY (`identifier`);

--
-- Indeks untuk tabel `pelaporan`
--
ALTER TABLE `pelaporan`
  ADD PRIMARY KEY (`id_pelaporan`);

--
-- Indeks untuk tabel `penduduk`
--
ALTER TABLE `penduduk`
  ADD PRIMARY KEY (`nik`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `suratketerangan`
--
ALTER TABLE `suratketerangan`
  ADD PRIMARY KEY (`no_surat`);

--
-- Indeks untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id_tagihan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jenis_surat`
--
ALTER TABLE `jenis_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
