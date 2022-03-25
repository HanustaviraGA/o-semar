-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Mar 2022 pada 14.50
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.1.2

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
('3534342493434', 'SRT6224973bb4193', '6224973bb419e_3534342493434.png', 'Pengajuan Surat', '2022-03-06', 'Pending', '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `msadmin`
--

CREATE TABLE `msadmin` (
  `nik` varchar(300) NOT NULL,
  `nama` varchar(300) NOT NULL,
  `username` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `alamat` varchar(300) NOT NULL,
  `no_kk` varchar(300) NOT NULL,
  `id_rt` varchar(300) NOT NULL,
  `id_rw` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `msadmin`
--

INSERT INTO `msadmin` (`nik`, `nama`, `username`, `password`, `alamat`, `no_kk`, `id_rt`, `id_rw`) VALUES
('123456789', 'Hanustavira Guru Acarya', 'hanhan', '$2y$10$O9sKO0J2qPhuIifqHrZeQuXFE531.sRjafE2SHD0yDh31lYKRKRPy', 'Klampis Ngasem', '999888777444', '5', '9');

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
  `nama_rt` varchar(300) NOT NULL,
  `nomor_sk` varchar(300) NOT NULL,
  `tanggal_sk` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `msrt`
--

INSERT INTO `msrt` (`id_rt`, `id_rw`, `nik_ketuart`, `nama_rt`, `nomor_sk`, `tanggal_sk`) VALUES
('1', '9', '3741520', 'Suhartini', '910/RT/478/2022', '2022-03-05'),
('2', '9', '6488254872501', 'Sudarmono', '455/RT/511/2022', '2022-03-05'),
('4', '8', '456789123', 'Cheryl Almeira', '', ''),
('5', '8', '12345678900', 'Zulkifli', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `msrw`
--

CREATE TABLE `msrw` (
  `id_rw` varchar(300) NOT NULL,
  `id_kelurahan` varchar(300) NOT NULL,
  `nik_ketuarw` varchar(300) NOT NULL,
  `nama_rw` varchar(300) NOT NULL,
  `nomor_sk` varchar(300) NOT NULL,
  `tanggal_sk` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `msrw`
--

INSERT INTO `msrw` (`id_rw`, `id_kelurahan`, `nik_ketuarw`, `nama_rw`, `nomor_sk`, `tanggal_sk`) VALUES
('8', '2013', '987456321', 'Andru Baskara Putra', '', ''),
('9', '2013', '66974215', 'Setyo', '', '');

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
  `acc_status` varchar(1) NOT NULL DEFAULT '1',
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

INSERT INTO `penduduk` (`no_kk`, `nik`, `nama`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `id_rt`, `id_rw`, `jenis_kelamin`, `agama`, `status_perkawinan`, `pekerjaan`, `gol_darah`, `kewarganegaraan`, `status_ktp`, `foto_ktp`, `email`, `username`, `password`, `acc_status`, `no_hp`, `status_hubungan_keluarga`, `no_paspor`, `no_kitas`, `kepala_keluarga`, `nama_ayah`, `nama_ibu`, `virtual_account_id`, `foto_kk`, `pendidikan`, `tanggal_pengeluaran_kk`, `tanggal_reg`) VALUES
('12345678900', '12345678900', 'Zulkifli', 'Tidak Diketahui', '2021-12-11', 'Tidak Diketahui', '5', '8', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'zulkifli@binus.ac.id', 'zulkifli', '$2y$10$Yz.XN0egTQdp6KFBcDK31u1vo.7YqsszKZJHa1r/tI5FoCQ6jvM9K', '1', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 0, 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', '2021-12-11', '2021-12-11'),
('12345678', '3534342493434', 'Luki', 'Tidak Diketahui', '2021-11-16', 'Tidak Diketahui', '7', '8', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'muhammad.masyhuri@binus.ac.id', 'luki', '$2y$10$O9sKO0J2qPhuIifqHrZeQuXFE531.sRjafE2SHD0yDh31lYKRKRPy', '1', 'Tidak Diketahui', '', '', '', 0, 'Hendra', 'Sri', '', '', '', '2021-12-01', '2021-11-16'),
('4479674', '3741520', 'Suhartini', 'Tidak Diketahui', '2021-12-08', 'Tidak Diketahui', '6', '8', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'suhartini@binus.ac.id', 'suhartini', '$2y$10$O9sKO0J2qPhuIifqHrZeQuXFE531.sRjafE2SHD0yDh31lYKRKRPy', '1', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 0, 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', '2021-12-08', '2021-12-08'),
('4479652', '3741554', 'Dionisius', 'Tidak Diketahui', '2021-12-08', 'Tidak Diketahui', '1', '9', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'dionisius@binus.ac.id', 'dion', '$2y$10$O9sKO0J2qPhuIifqHrZeQuXFE531.sRjafE2SHD0yDh31lYKRKRPy', '1', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 0, 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', '2021-12-08', '2021-12-08'),
('897', '456789123', 'Cheryl Almeira', '', '2021-10-27', '', '4', '8', '', '', '', '', '', '', '', '', '', 'cheryl', '$2y$10$O9sKO0J2qPhuIifqHrZeQuXFE531.sRjafE2SHD0yDh31lYKRKRPy', '1', '', '', '', '', 1, '', '', '', '', '', '2021-12-01', '0000-00-00'),
('2251484774500', '6488254872501', 'Sudarmono', 'Tidak Diketahui', '0000-00-00', 'Tidak Diketahui', '1', '10', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'sudarmono@binus.ac.id', 'sudarmono', '$2y$10$O9sKO0J2qPhuIifqHrZeQuXFE531.sRjafE2SHD0yDh31lYKRKRPy', '1', 'Tidak Diketahui', '', '', '', 0, '', '', '', '', '', '2021-12-01', '2021-11-16'),
('35679524', '66974215', 'Setyo', 'Tidak Diketahui', '2021-12-10', 'Tidak Diketahui', '1', '9', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'setyo@binus.ac.id', 'setyo', '$2y$10$O9sKO0J2qPhuIifqHrZeQuXFE531.sRjafE2SHD0yDh31lYKRKRPy', '0', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 0, 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', '2021-12-10', '2021-12-10'),
('664', '987456321', 'Andru Baskara Putra', '', '0000-00-00', '', '3', '8', '', '', '', '', '', '', '', '', '', 'andru', '$2y$10$O9sKO0J2qPhuIifqHrZeQuXFE531.sRjafE2SHD0yDh31lYKRKRPy', '1', '', '', '', '', 0, '', '', '', '', '', '2021-12-01', '0000-00-00');

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

-- --------------------------------------------------------

--
-- Struktur dari tabel `suratketerangan`
--

CREATE TABLE `suratketerangan` (
  `index` int(100) NOT NULL,
  `no_surat` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `identifier` varchar(300) NOT NULL,
  `nik` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `nama` varchar(300) DEFAULT NULL,
  `id_rt` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `id_rw` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `jenis` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `keperluan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `tanggal_pengajuan` date NOT NULL DEFAULT current_timestamp(),
  `tujuan` varchar(300) NOT NULL,
  `keterangan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `status` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `status_rt` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `status_rw` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `status_admin` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `alasan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `suratketerangan`
--

INSERT INTO `suratketerangan` (`index`, `no_surat`, `identifier`, `nik`, `nama`, `id_rt`, `id_rw`, `jenis`, `keperluan`, `tanggal_pengajuan`, `tujuan`, `keterangan`, `status`, `status_rt`, `status_rw`, `status_admin`, `alasan`) VALUES
(8, '8/6/3/9.3.7.8/2022', 'SRT6224973bb4193', '3534342493434', NULL, '7', '8', 'Surat Keterangan Akan Menikah', 'Keberangkatan ke luar negeri', '2022-03-06', 'KUA Surabaya', 'Test', 'Pending', '-', '-', '-', 'Tidak Diketahui');

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
  ADD PRIMARY KEY (`index`);

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

--
-- AUTO_INCREMENT untuk tabel `suratketerangan`
--
ALTER TABLE `suratketerangan`
  MODIFY `index` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
