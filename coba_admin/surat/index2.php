<?php
  include '../../koneksi.php';
  session_start();
  if (!isset($_SESSION['keadaan']) && !$_SESSION['keadaan'] == "sudah_login_user") {
    header("Location: ../login.php");
    exit;
  }
  $sql = "SELECT * FROM suratketerangan";
  $query = mysqli_query($koneksi,$sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tabel Data</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../css/app.css">
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
                <p>Dashboard</p>
                <i class="fas fa-chevron-right"></i>
            </a>
            <a href="../surat/index2.php" class="sidebar-link sidebar-active">
                <p>Tabel Data - Template</p>
                <i class="fas fa-chevron-right"></i>
            </a>
            <a href="../super/pengaturan2.php" class="sidebar-link">
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
        
        
        <main class="table-panel">
            <h1>Tabel Data</h1>
            <section class="table-content">
                <div class="table-nav">
                    <div class="entry-menu">
                        <p>Show</p>
                        <select name="entry" id="entry">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <p>entries</p>
                    </div>
                    <form method="POST" class="searchbar">
                        <label for="search">Search: </label>
                        <input type="text" name="search" id="search">
                    </form>
                </div>
                <table class="table-data">
                    <tr>
                        <th>Nomor Surat</th>
                        <th>Nama</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    <?php while($data = mysqli_fetch_array($query)):?>
                    <tr>
                        <td><?= $data['no_surat']; ?></td>
                        <td><?= $data['nama']; ?></td>
                        <td><?= $data['tujuan']; ?></td>
                        <td><?= $data['tanggal_pengajuan']; ?></td>
                        <td><?= $data['status']; ?></td>
                        <td>
                            <a href="www.google.com">
                                <button>DETAIL</button>
                            </a> 
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
                <div class="table-bot-nav">
                    <p>Showing 1 to 10 of ... entries</p>
                    <div class="table-btn-group">
                        <a href="">Previous</a>
                        <a href="" class="active">1</a>
                        <a href="" class="">2</a>
                        <a href="">Next</a>
                    </div>
                </div>
            </section>
        </main>
        
    </main>
    
</body>

</html>
