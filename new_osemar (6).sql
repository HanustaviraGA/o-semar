-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Des 2021 pada 09.45
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
-- Struktur dari tabel `jenis_surat`
--

CREATE TABLE `jenis_surat` (
  `id` int(11) NOT NULL,
  `jenis` varchar(300) NOT NULL,
  `keterangan_jenis` varchar(300) NOT NULL,
  `identifier` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jenis_surat`
--

INSERT INTO `jenis_surat` (`id`, `jenis`, `keterangan_jenis`, `identifier`) VALUES
(1, 'Surat Keterangan Penghasilan', 'Untuk memberikan keterangan bahwa penduduk telah bekerja dan memiliki penghasilan', 1),
(2, 'Surat Keterangan Pindah', 'Sebagai surat pengantar di tempat tujuan yang menerangkan mengenai asal domisili penduduk', 1);

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
('321654999', 'SRT61af1997e721a', '61af1997e7222_321654999.png', 'Pengajuan Surat', '2021-12-07', 'Pending', '-'),
('321654999', 'SRT61af1997e721a', '61af1997e8165_321654999.jpg', 'Pengajuan Surat', '2021-12-07', 'Pending', '-'),
('123456789', 'LPR61af1ceacf32d', '61af1ceacf336_123456789.jpg', 'Laporan Masyarakat', '2021-12-07', 'Pending', '-'),
('123456789', 'LPR61af1ceacf32d', '61af1cead2a92_123456789.png', 'Laporan Masyarakat', '2021-12-07', 'Pending', '-');

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
('4', '8', '456789123', 'Cheryl Almeira');

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
('8', '2013', '987456321', 'Andru Baskara Putra');

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
('LPR61af1ceacf32d', '123456789', '4', '8', 'Tata Tertib', 'Mohon agar segera ditindaklanjuti', '2021-12-07', 'Pending', '');

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
('123888', '222333666', 'Budiman', 'Surabaya', '0000-00-00', '', '4', '8', '', '', '', '', '', '', '', '', '', '', 'buwinajoss', '', '', '', '', 1, '', '', '', '', '', '2021-12-01', '0000-00-00'),
('333', '321654987', 'Michelle Angela Guntjoro', '', '2001-06-27', '', '5', '8', '', '', '', '', '', '', '', '', '', 'cele', 'buwinajoss', '', '', '', '', 1, '', '', '', '', '', '2021-12-01', '0000-00-00'),
('999777444', '333111222', 'Hanustavira Guru Acarya', '', '0000-00-00', '', '4', '8', '', '', '', '', '', '', '', '', 'hanvir@sunib.com', 'hanhan', 'buwinajoss', '', '', '', '', 1, '', '', '', 'KK_12345678.jpg', '', '2021-12-01', '0000-00-00'),
('12345678', '3534342493434', 'Luki', 'Tidak Diketahui', '2021-11-16', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'muhammad.masyhuri@binus.ac.id', 'fikri', 'buwinajoss', 'Tidak Diketahui', '', '', '', 0, 'Hendra', 'Sri', '', '', '', '2021-12-01', '2021-11-16'),
('12345678', '3534342493436', 'Sumartono', 'Tidak Diketahui', '2021-11-16', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'muhammad.masyhuri@binus.ac.id', 'fikris', 'buwinajoss', 'Tidak Diketahui', '', '', '', 0, 'Sugiyanto', 'Dewi', '', '', '', '2021-12-01', '2021-11-16'),
('35794523974461', '35794510335481', 'Sanusi', 'Tidak Diketahui', '2021-11-16', 'Tidak Diketahui', '4', '9', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'dhani@binus.ac.id', 'dhani', 'buwinajoss', 'Tidak Diketahui', '', '', '', 1, '', '', '', '', '', '2021-12-01', '2021-11-16'),
('897', '456789123', 'Cheryl Almeira', '', '2021-10-27', '', '4', '8', '', '', '', '', '', '', '', '', '', 'cheryl', 'buwinajoss', '', '', '', '', 1, '', '', '', '', '', '2021-12-01', '0000-00-00'),
('2251484774424', '6488254872334', 'Surip', 'Tidak Diketahui', '2021-11-16', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'suherman@binus.ac.id', 'suherman', 'buwinajoss', 'Tidak Diketahui', '', '', '', 0, '', '', '', '', '', '2021-12-01', '2021-11-16'),
('2251484774500', '6488254872501', 'Sudarmono', 'Tidak Diketahui', '0000-00-00', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'sudarmono@binus.ac.id', 'sudarmono', 'buwinajoss', 'Tidak Diketahui', '', '', '', 0, '', '', '', '', '', '2021-12-01', '2021-11-16'),
('554', '654987321', 'Gerry Guinardi', '', '0000-00-00', '', '4', '8', '', '', '', '', '', '', '', '', '', 'overlord', 'buwinajoss', '', '', '', '', 0, '', '', '', '', '', '2021-12-01', '0000-00-00'),
('1234567890', '92919010293', 'Fikri Imaduddin', 'Tidak Diketahui', '2021-12-06', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'fikri.iaim@gmail.com', 'fikcoy', 'buwinajoss', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 0, 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', 'Tidak Diketahui', '2021-12-06', '2021-12-06'),
('664', '987456321', 'Andru Baskara Putra', '', '0000-00-00', '', '3', '8', '', '', '', '', '', '', '', '', '', 'andru', 'buwinajoss', '', '', '', '', 0, '', '', '', '', '', '2021-12-01', '0000-00-00');

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
('A975541', 'Penertiban Parkir Liar Warga', 'Dimohon bagi warga RT 4 RW 8 untuk tidak memarkirkan kendaraannya di tepi jalan umum.', '2021-12-04', '5', '8', 'Kepala RW 8 - Andru Baskara Putra');

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
  `keterangan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `status` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui',
  `alasan` varchar(300) NOT NULL DEFAULT 'Tidak Diketahui'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `suratketerangan`
--

INSERT INTO `suratketerangan` (`no_surat`, `nik`, `id_rt`, `id_rw`, `jenis`, `keperluan`, `tanggal_pengajuan`, `keterangan`, `status`, `alasan`) VALUES
('A98EDB', '123456789', '4', '8', '', 'Pengurusan Izin Usaha', '2021-10-13', 'Dibutuhkan mendesak', 'Terverifikasi', ''),
('SRT61af1997e721a', '321654999', '4', '8', 'Surat Keterangan Belum Menikah', 'Pengurusan Surat Kerja', '2021-12-07', 'Dibutuhkan Mendesak', 'Pending', '-');

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
('1', '123456789', '4', '8', 'Keamanan', 500000, '2021-10-01', 'Lunas', '444444', 'foto', '2021-10-07'),
('2', '987456321', '4', '8', 'Kebersihan', 100000, '2021-10-17', 'Telat', '555555', 'null', '2021-10-18');

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
  ADD PRIMARY KEY (`nik`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
