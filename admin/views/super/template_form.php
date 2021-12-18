<?php
  include '../../../koneksi.php';
  session_start();
  if (!isset($_SESSION['keadaan']) && !$_SESSION['keadaan'] == "sudah_login_user") {
    header("Location: ../login.php");
    exit;
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tabel Data</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../assets/css/app.css">
    
    <!-- <script src="http://127.0.0.1:8000/js/app.js"></script> -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"
        integrity="sha512-YSdqvJoZr83hj76AIVdOcvLWYMWzy6sJyIMic2aQz5kh2bPTd9dzY3NtdeEAzPp/PhgZqr4aJObB3ym/vsItMg=="
        crossorigin="anonymous"></script>
</head>

<body class="flex">
    
    <aside class="sidebar">
        <div class="logo">
            <h1 class="text-2xl">O-Semar</h1>
        </div>
        <nav class="sidebar-menu">
            <a href="../index2.php" class="sidebar-link">
                <i class="fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
                <i class="fas fa-chevron-right"></i>
            </a>
            <div class="divider-horizontal"></div>
            <p>Layanan</p>
            <a href="../surat/index2.php" class="sidebar-link">
                <i class="fas fa-table"></i>
                <p>Pengajuan Surat</p>
                <i class="fas fa-chevron-right"></i>
            </a>
            <a href="../iuran/index2.php" class="sidebar-link">
                <i class="fas fa-table"></i>
                <p>Pembayaran Iuran</p>
                <i class="fas fa-chevron-right"></i>
            </a>
            <a href="../laporan/index2.php" class="sidebar-link">
                <i class="fas fa-table"></i>
                <p>Pelaporan</p>
                <i class="fas fa-chevron-right"></i>
            </a>
            <a href="../adminduk/kartu_keluarga/index2.php" class="sidebar-link">
                <i class="fas fa-table"></i>
                <p>Kartu Keluarga</p>
                <i class="fas fa-chevron-right"></i>
            </a>
            <a href="../adminduk/list_penduduk/index2.php" class="sidebar-link">
                <i class="fas fa-table"></i>
                <p>Daftar Penduduk</p>
                <i class="fas fa-chevron-right"></i>
            </a>
            <div class="divider-horizontal"></div>
            <p>Administrator</p>
            <a href="../super/pengaturan2.php" class="sidebar-link">
                <i class="fas fa-table"></i>
                <p>Pengaturan Wilayah</p>
                <i class="fas fa-chevron-right"></i>
            </a>
            <a href="../super/list_rt2.php" class="sidebar-link">
                <i class="fas fa-table"></i>
                <p>Pengaturan RT</p>
                <i class="fas fa-chevron-right"></i>
            </a>
            <a href="../super/list_rw2.php" class="sidebar-link">
                <i class="fas fa-table"></i>
                <p>Pengaturan RW</p>
                <i class="fas fa-chevron-right"></i>
            </a>
        </nav>
    </aside>

    <main class="dashboard-content">
        
        <header class="panel-navbar">
            <div class="toogle-sidebar">
                <i class="fas fa-bars"></i>
            </div>
            <div class="panel-nav flex">
                <div class="menus mx-2 flex justify-center items-center">
                    <div class="search">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="bell">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="mail">
                        <i class="far fa-envelope"></i>
                    </div>
                    <div class="tasks">
                        <i class="fas fa-tasks"></i>
                    </div>
                </div>
                <div class="divider-vertical mx-2 border-r"></div>
                <div class="profile">
                    <div class="avatar">
                        <i class="fas fa-user-alt"></i>
                    </div>
                    <p><?php echo $_SESSION['nama_admin']; ?></p>
                </div>
            </div>
        </header>
        
        <main class="form-panel">
            <h1>Form</h1>
            <form method="POST" class="form-content">
                <div class="form-input">
                    <label for="pelapor">Nama Pelapor</label>
                    <input type="text" name="pelapor" id="pelapor">
                </div>
                <div class="form-input">
                    <label for="laporan">Judul Laporan</label>
                    <input type="text" name="laporan" id="laporan">
                </div>
                <div class="form-input">
                    <label for="kategori">Kategori Laporan</label>
                    <input type="text" name="kategori" id="kategori">
                </div>
                <div class="form-input">
                    <label for="tanggal">Tanggal Laporan</label>
                    <input type="date" name="tanggal" id="tanggal">
                </div>
                <div class="form-input">
                    <label for="bukti">Bukti Laporan</label>
                    <input type="file" name="bukti" id="bukti">
                </div>
                <div class="form-input">
                    <button type="button">Verifikasi</button>
                    <button type="button">Tolak</button>
                </div>
            </form>
        </main>
        
        <main class="form-panel">
            
        </main>
        
    </main>
    
</body>

</html>
