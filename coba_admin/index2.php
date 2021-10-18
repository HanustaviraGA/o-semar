<?php
    include '../koneksi.php';
    session_start();
    if(!isset($_SESSION['keadaan']) && !$_SESSION['keadaan'] == "sudah_login_user") {
        header("Location: login.php?pesan=Anda harus login dulu !");
        exit;
    }else if (isset($_SESSION['keadaan']) && $_SESSION['keadaan'] == "sudah_login_user") {
        echo "";
    } else if (isset($_SESSION['keadaan']) && $_SESSION['keadaan'] == "sudah_login_user"){
        echo "";
    }
    // Pengajuan
    $sqlPengajuan = "SELECT COUNT(*) AS 'countPng' from suratketerangan";
    $hasilPengajuan = mysqli_query($koneksi, $sqlPengajuan);
    $dataPengajuan = mysqli_fetch_array($hasilPengajuan);
    $sql = "SELECT * FROM suratketerangan";
    $query = mysqli_query($koneksi,$sql);
    $data = mysqli_fetch_array($query);

    // Pelaporan
    $sqlPelaporan = "SELECT COUNT(*) AS 'countLapor' from pelaporan";
    $hasilPelaporan = mysqli_query($koneksi, $sqlPelaporan);
    $dataPelaporan = mysqli_fetch_array($hasilPelaporan);
    $sql2 = "SELECT * FROM pelaporan";
    $query2 = mysqli_query($koneksi,$sql2);
    $data2 = mysqli_fetch_array($query2);

    // Penduduk
    $sqlPenduduk = "SELECT COUNT(*) AS 'countWarga' from penduduk";
    $hasilPenduduk = mysqli_query($koneksi, $sqlPenduduk);
    $dataPenduduk = mysqli_fetch_array($hasilPenduduk);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="css/app.css">
    
    <!-- <script src="http://127.0.0.1:8000/js/app.js"></script> -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js" integrity="sha512-YSdqvJoZr83hj76AIVdOcvLWYMWzy6sJyIMic2aQz5kh2bPTd9dzY3NtdeEAzPp/PhgZqr4aJObB3ym/vsItMg==" crossorigin="anonymous"></script>
</head>

<body class="flex">
    
    <aside class="sidebar">
        <div class="logo">
            <h1 class="text-2xl">O-Semar</h1>
        </div>
        <nav class="sidebar-menu">
            <a href="index2.php" class="sidebar-link sidebar-active">
                <p>Dashboard</p>
                <i class="fas fa-chevron-right"></i>
            </a>
            <a href="surat/index2.php" class="sidebar-link">
                <p>Tabel Data - Template</p>
                <i class="fas fa-chevron-right"></i>
            </a>
            <a href="super/pengaturan2.php" class="sidebar-link">
                <p>Form Data - Template</p>
                <i class="fas fa-chevron-right"></i>
            </a>
            <a href="/" class="sidebar-link">
                <p>Laravel Introduction</p>
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
        
        
        <main class="dashboard-panel">
            <section class="info-counting">
                <div class="info">
                    <div class="count bg-blue-400">
                        <p><?= $dataPengajuan['countPng'] ?></p>
                    </div>
                    <p>Jumlah Pengajuan</p>
                </div>
                <div class="info">
                    <div class="count bg-orange-400">
                        <p><?= $dataPelaporan['countLapor'] ?></p>
                    </div>
                    <p>Jumlah Pelaporan</p>
                </div>
                <div class="info">
                    <div class="count bg-teal-400">
                        <p><?= $dataPenduduk['countWarga'] ?></p>
                    </div>
                    <p>Jumlah Warga</p>
                </div>
            </section>
            <section class="report-info">
                <div class="pengajuan">
                    <h1>Pengajuan Terbaru</h1>
                    <div class="list">
                        <div class="report">
                            <div class="report-detail">
                                <h2><?= $data['keperluan']; ?></h2>
                                <p><?= $data['tanggal_pengajuan']; ?></p>
                            </div>
                            <div class="report-assigner">
                                <img src="" alt="Warga">
                                <p><?= $data['nama']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pelaporan">
                    <h1>Pelaporan Terbaru</h1>
                    <div class="list">
                        <div class="report">
                            <img src="" alt="Foto Laporan" class="report-image">
                            <div class="report-content">
                                <div class="report-detail">
                                    <h2>Judul pengajuan</h2>
                                    <p>2 hari yang lalu</p>
                                </div>
                                <div class="report-assigner">
                                    <img src="" alt="Warga">
                                    <p>Nama warga</p>
                                </div>
                            </div>
                        </div>
                        <div class="report">
                            <img src="" alt="Foto Laporan" class="report-image">
                            <div class="report-content">
                                <div class="report-detail">
                                    <h2>Judul pengajuan</h2>
                                    <p>2 hari yang lalu</p>
                                </div>
                                <div class="report-assigner">
                                    <img src="" alt="Warga">
                                    <p>Nama warga</p>
                                </div>
                            </div>
                        </div>
                        <div class="report">
                            <img src="" alt="Foto Laporan" class="report-image">
                            <div class="report-content">
                                <div class="report-detail">
                                    <h2>Judul pengajuan</h2>
                                    <p>2 hari yang lalu</p>
                                </div>
                                <div class="report-assigner">
                                    <img src="" alt="Warga">
                                    <p>Nama warga</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        
    </main>
    
</body>

</html>
