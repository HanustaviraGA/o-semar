-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Okt 2021 pada 16.45
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.10

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
-- Struktur dari tabel `kartu_keluarga`
--

CREATE TABLE `kartu_keluarga` (
  `no_kk` varchar(300) NOT NULL,
  `nik` varchar(300) NOT NULL,
  `status_hubungan` varchar(300) NOT NULL,
  `no_paspor` varchar(300) NOT NULL,
  `no_kitas` varchar(300) NOT NULL,
  `kepala_keluarga` varchar(300) NOT NULL,
  `nama_ayah` varchar(300) NOT NULL,
  `nama_ibu` varchar(300) NOT NULL,
  `id_rt` varchar(300) NOT NULL,
  `id_rw` varchar(300) NOT NULL,
  `alamat` varchar(300) NOT NULL,
  `tanggal_pengeluaran` date NOT NULL,
  `foto_kk` varchar(300) NOT NULL,
  `virtual_account_id` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kartu_keluarga`
--

INSERT INTO `kartu_keluarga` (`no_kk`, `nik`, `status_hubungan`, `no_paspor`, `no_kitas`, `kepala_keluarga`, `nama_ayah`, `nama_ibu`, `id_rt`, `id_rw`, `alamat`, `tanggal_pengeluaran`, `foto_kk`, `virtual_account_id`) VALUES
('12345678', '123456789', 'Menikah', '212121212122', '111111111', 'Hanustavira Guru Acarya', 'Hanustavira Guru Acarya', 'Hanustavira Guru Acarya', '1212121222222', '67777777777', ':V :V :V', '2021-10-01', '', '1212121222222222222222222');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lampiran`
--

CREATE TABLE `lampiran` (
  `no_id` varchar(300) NOT NULL,
  `jenis_lampiran` varchar(300) NOT NULL,
  `tanggal_lampiran` varchar(300) NOT NULL,
  `status_lampiran` varchar(300) NOT NULL,
  `ket_lampiran` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mskabkota`
--

CREATE TABLE `mskabkota` (
  `id_kabkota` varchar(300) NOT NULL,
  `id_provinsi` varchar(300) NOT NULL,
  `nama_kabkota` varchar(300) NOT NULL
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
  `id_kecamatan` varchar(300) NOT NULL,
  `id_kabkota` varchar(300) NOT NULL,
  `nama_kecamatan` varchar(300) NOT NULL
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
  `id_kelurahan` varchar(300) NOT NULL,
  `id_kecamatan` varchar(300) NOT NULL,
  `nama_kelurahan` varchar(300) NOT NULL
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
('35', 'Jawa Timur'),
('33', 'Jawa Tengah'),
('32', 'Jawa Barat'),
('34', 'DAISTA Yogyakarta'),
('32', 'Jawa Barat'),
('34', 'DAISTA Yogyakarta');

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
  `nama_kelurahan` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `mssettings`
--

INSERT INTO `mssettings` (`identifier`, `id_provinsi`, `nama_provinsi`, `id_kabkota`, `nama_kabkota`, `id_kecamatan`, `nama_kecamatan`, `id_kelurahan`, `nama_kelurahan`) VALUES
(1, '35', 'Jawa Timur', '07', 'Kabupaten Malang', '24', 'Singosari', '2013', 'Desa Ardimulyo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelaporan`
--

CREATE TABLE `pelaporan` (
  `id_pelaporan` varchar(300) NOT NULL,
  `nik` varchar(300) NOT NULL,
  `tujuan` varchar(300) NOT NULL,
  `keperluan` varchar(300) NOT NULL,
  `keterangan` varchar(300) NOT NULL,
  `tanggal_pelaporan` date NOT NULL,
  `status` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penduduk`
--

CREATE TABLE `penduduk` (
  `nik` varchar(300) NOT NULL,
  `nama` varchar(300) NOT NULL,
  `tempat_lahir` varchar(300) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(300) NOT NULL,
  `id_rt` varchar(300) NOT NULL,
  `id_rw` varchar(300) NOT NULL,
  `jenis_kelamin` varchar(300) NOT NULL,
  `agama` varchar(300) NOT NULL,
  `status_perkawinan` varchar(300) NOT NULL,
  `pekerjaan` varchar(300) NOT NULL,
  `gol_darah` varchar(300) NOT NULL,
  `kewarganegaraan` varchar(300) NOT NULL,
  `status_ktp` varchar(300) NOT NULL,
  `foto_ktp` varchar(300) NOT NULL,
  `username` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `no_hp` varchar(300) NOT NULL,
  `tanggal_reg` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penduduk`
--

INSERT INTO `penduduk` (`nik`, `nama`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `id_rt`, `id_rw`, `jenis_kelamin`, `agama`, `status_perkawinan`, `pekerjaan`, `gol_darah`, `kewarganegaraan`, `status_ktp`, `foto_ktp`, `username`, `password`, `no_hp`, `tanggal_reg`) VALUES
('123456789', 'Hanustavira Guru Acarya', '', '0000-00-00', '', '3', '5', '', '', '', '', '', '', '', '', 'hanvir', 'sunibngalam', '', '0000-00-00'),
('987456321', 'Andru Baskara Putra', '', '0000-00-00', '', '3', '1', '', '', '', '', '', '', '', '', 'andru', 'sunibngalam', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `pengumuman` varchar(300) NOT NULL,
  `tanggal` date NOT NULL,
  `id_rt` varchar(300) NOT NULL,
  `id_rw` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `suratketerangan`
--

CREATE TABLE `suratketerangan` (
  `no_surat` varchar(300) NOT NULL,
  `nik` varchar(300) NOT NULL,
  `nama` varchar(300) NOT NULL,
  `tujuan` varchar(300) NOT NULL,
  `keperluan` varchar(300) NOT NULL,
  `tempat_pengajuan` varchar(300) NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `keterangan` varchar(300) NOT NULL,
  `status` varchar(300) NOT NULL,
  `alasan` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `suratketerangan`
--

INSERT INTO `suratketerangan` (`no_surat`, `nik`, `nama`, `tujuan`, `keperluan`, `tempat_pengajuan`, `tanggal_pengajuan`, `keterangan`, `status`, `alasan`) VALUES
('A98EDB', '123456789', 'Sunyoto', 'Diskominfo', 'Pengurusan Izin Usaha', 'Kantor Desa Ardimulyo', '2021-10-13', 'Dibutuhkan mendesak', 'Terverifikasi', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tagihan`
--

CREATE TABLE `tagihan` (
  `id_tagihan` varchar(300) NOT NULL,
  `nik` varchar(300) NOT NULL,
  `jenis_tagihan` varchar(300) NOT NULL,
  `total_tagihan` int(255) NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `status_pembayaran` varchar(300) NOT NULL,
  `rekening` varchar(300) NOT NULL,
  `bukti_pembayaran` varchar(300) NOT NULL,
  `tanggal_pembayaran` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tagihan`
--

INSERT INTO `tagihan` (`id_tagihan`, `nik`, `jenis_tagihan`, `total_tagihan`, `jatuh_tempo`, `status_pembayaran`, `rekening`, `bukti_pembayaran`, `tanggal_pembayaran`) VALUES
('1', '123456789', 'Keamanan', 500000, '2021-10-01', 'Pending', '444444', 'foto', '2021-10-07'),
('2', '987456321', 'Kebersihan', 100000, '2021-10-17', 'Telat', '555555', 'null', '2021-10-18');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `penduduk`
--
ALTER TABLE `penduduk`
  ADD PRIMARY KEY (`nik`);

--
-- Indeks untuk tabel `suratketerangan`
--
ALTER TABLE `suratketerangan`
  ADD PRIMARY KEY (`no_surat`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
