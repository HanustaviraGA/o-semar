<?php
    include '../../koneksi.php';
    session_start();
    if(!isset($_SESSION['keadaan']) && !$_SESSION['keadaan'] == "sudah_login_admin") {
        header("Location: login?pesan=Anda harus login dulu !");
        exit;
    }else if (isset($_SESSION['keadaan']) && $_SESSION['keadaan'] == "sudah_login_admin") {
        echo "";
    } else if (isset($_SESSION['keadaan']) && $_SESSION['keadaan'] == "sudah_login_admin"){
        echo "";
    }
    // Status login
    $status = $_SESSION['keadaan'];
    $nik = $_SESSION['nik'];
    $rt = $_SESSION['rt'];
    $rw = $_SESSION['rw'];
    if($status == "sudah_login_admin"){
      $sqlLaporan = "SELECT COUNT(*) AS 'countLaporan' from pelaporan";
      $hasilLaporan = mysqli_query($koneksi, $sqlLaporan);
      $dataLaporan = mysqli_fetch_array($hasilLaporan);

      $sqlSurat = "SELECT COUNT(*) AS 'countSurat' from suratketerangan";
      $hasilSurat = mysqli_query($koneksi, $sqlSurat);
      $dataSurat = mysqli_fetch_array($hasilSurat);

      $sqlIuran = "SELECT SUM(total_tagihan) AS 'jumlahIuran' FROM tagihan WHERE status_pembayaran='Paid'";
      $hasilIuran = mysqli_query($koneksi, $sqlIuran);
      $dataIuran = mysqli_fetch_array($hasilIuran);
    }else if($status == "sudah_login_penduduk"){
      $sqlLaporan = "SELECT COUNT(*) AS 'countLaporan' from pelaporan";
      $hasilLaporan = mysqli_query($koneksi, $sqlLaporan);
      $dataLaporan = mysqli_fetch_array($hasilLaporan);

      $sqlSurat = "SELECT COUNT(*) AS 'countSurat' from suratketerangan";
      $hasilSurat = mysqli_query($koneksi, $sqlSurat);
      $dataSurat = mysqli_fetch_array($hasilSurat);

      $sqlIuran = "SELECT SUM(total_tagihan) AS 'jumlahIuran' FROM tagihan WHERE status_pembayaran='Paid'";
      $hasilIuran = mysqli_query($koneksi, $sqlIuran);
      $dataIuran = mysqli_fetch_array($hasilIuran);
    }else if($status == "sudah_login_rt"){
      $sqlLaporan = "SELECT COUNT(*) AS 'countLaporan' from pelaporan";
      $hasilLaporan = mysqli_query($koneksi, $sqlLaporan);
      $dataLaporan = mysqli_fetch_array($hasilLaporan);

      $sqlSurat = "SELECT COUNT(*) AS 'countSurat' from suratketerangan";
      $hasilSurat = mysqli_query($koneksi, $sqlSurat);
      $dataSurat = mysqli_fetch_array($hasilSurat);

      $sqlIuran = "SELECT SUM(total_tagihan) AS 'jumlahIuran' FROM tagihan WHERE status_pembayaran='Paid'";
      $hasilIuran = mysqli_query($koneksi, $sqlIuran);
      $dataIuran = mysqli_fetch_array($hasilIuran);
    }else if($status == "sudah_login_rw"){
      $sqlLaporan = "SELECT COUNT(*) AS 'countLaporan' from pelaporan";
      $hasilLaporan = mysqli_query($koneksi, $sqlLaporan);
      $dataLaporan = mysqli_fetch_array($hasilLaporan);

      $sqlSurat = "SELECT COUNT(*) AS 'countSurat' from suratketerangan";
      $hasilSurat = mysqli_query($koneksi, $sqlSurat);
      $dataSurat = mysqli_fetch_array($hasilSurat);

      $sqlIuran = "SELECT SUM(total_tagihan) AS 'jumlahIuran' FROM tagihan WHERE status_pembayaran='Paid'";
      $hasilIuran = mysqli_query($koneksi, $sqlIuran);
      $dataIuran = mysqli_fetch_array($hasilIuran);
    }
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="assets/img/logo/logo.png" rel="icon">
  <title>O-SEMAR - Dashboard</title>
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="assets/css/ruang-admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- sidebar -->
    <?php 
      include 'layout/sidebar-index.php';
    ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php 
          include 'layout/navbar-index.php';
        ?>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Selamat Datang, <?php echo $_SESSION['nama_admin']; ?> !</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <div class="row mb-3">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Iuran Warga</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= $dataIuran['jumlahIuran'] ?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span>Terbayar</span>
                      </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-money-bill-wave fa-2x text-primary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Earnings (Annual) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Laporan</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $dataLaporan['countLaporan'] ?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span>Tersedia</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-exclamation-triangle fa-2x text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- New User Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Pengguna Baru</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">366</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 20.4%</span>
                        <span>Sejak 1 bulan terakhir</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Pengajuan Surat</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $dataSurat['countSurat'] ?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span>Tersedia</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-2x text-warning"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php 
                    
                    if(isset($status) && $status == "sudah_login_admin"){
                      $sql = "SELECT * FROM tagihan ORDER BY jatuh_tempo DESC LIMIT 4";
                      $query = mysqli_query($koneksi,$sql);
                    }else if(isset($status) && $status == "sudah_login_rt"){
                      $rt = $_SESSION['rt'];
                      $rw = $_SESSION['rw'];
                      $sql = "SELECT * FROM tagihan WHERE id_rt=$rt AND id_rw = $rw ORDER BY jatuh_tempo DESC LIMIT 4";
                      $query = mysqli_query($koneksi,$sql);
                    }else if(isset($status) && $status == "sudah_login_rw"){
                      $rw = $_SESSION['rw'];
                      $sql = "SELECT * FROM tagihan WHERE id_rw=$rw ORDER BY jatuh_tempo DESC LIMIT 4";
                      $query = mysqli_query($koneksi,$sql);
                    }else if(isset($status) && $status == "sudah_login_penduduk"){
                      $nik = $_SESSION['nik'];
                      $sql = "SELECT * FROM tagihan WHERE nik = $nik ORDER BY jatuh_tempo DESC LIMIT 4";
                      $query = mysqli_query($koneksi,$sql);
                    }
                    
            ?>
            <!-- Invoice Example -->
            <div class="col-xl-8 col-lg-7 mb-4">
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <?php if($status == "sudah_login_penduduk"){?>
                    <h6 class="m-0 font-weight-bold text-primary">Iuran Anda</h6>
                  <?php }else if($status == "sudah_login_rt"){?>
                    <h6 class="m-0 font-weight-bold text-primary">Iuran Warga RT <?= $_SESSION['rt'];?> RW <?= $_SESSION['rw'];?> </h6>
                  <?php }else if($status == "sudah_login_rw"){?>
                    <h6 class="m-0 font-weight-bold text-primary">Iuran Warga RW <?= $_SESSION['rw'];?></h6>
                  <?php }else if($status == "sudah_login_admin"){?>
                    <h6 class="m-0 font-weight-bold text-primary">Iuran Warga</h6>
                  <?php }?>
                  <a class="m-0 float-right btn btn-danger btn-sm" href="iuran/index">Selengkapnya<i
                      class="fas fa-chevron-right"></i></a>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                      <tr>
                        <th>Nama</th>
                        <th>Perihal</th>
                        <th>Jatuh Tempo</th>
                        <th>Status Pembayaran</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Nama</th>
                        <th>Perihal</th>
                        <th>Jatuh Tempo</th>
                        <th>Status Pembayaran</th>
                        <th>Aksi</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php while($data = mysqli_fetch_array($query)):?>
                        <tr>
                          <?php
                            $nik = $data['nik']; 
                            $sqlID = "SELECT nama FROM penduduk WHERE nik='$nik'";
                            $queryID = mysqli_query($koneksi,$sqlID);
                            $dataID = mysqli_fetch_array($queryID);
                          ?>
                          <td><?= $dataID['nama'] ?></td>
                          <td><?= $data['jenis_tagihan'] ?></td>
                          <td><?= $data['jatuh_tempo'] ?></td>
                          <td><?php if($data['status_pembayaran'] == 'Paid'){ ?>
                            <span class="badge badge-success">Lunas</span>
                          <?php }else if($data['status_pembayaran'] == 'Unpaid'){?>
                            <span class="badge badge-danger">Belum Terbayar</span>
                          <?php } ?></td>
                          <td>
                            <a href="detail?id=<?= $data['id_tagihan'] ?>">
                              <button class="btn btn-primary">Detail</button>
                            </a>
                          </td>
                        </tr>
                    <?php endwhile; ?>    
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
            </div>
            <!-- Message From Customer-->
            <div class="col-xl-4 col-lg-5 ">
              <div class="card">
                <div class="card-header py-4 bg-primary d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-light">Pengumuman Warga</h6>
                </div>
                <div>
                  <?php 
                    // Status login
                    if(isset($status) && $status == "sudah_login_admin"){
                      $sql_pengumuman = "SELECT * FROM pengumuman ORDER BY tanggal DESC LIMIT 4";
                      $query_pengumuman = mysqli_query($koneksi,$sql_pengumuman);
                    }else if(isset($status) && $status == "sudah_login_rt"){
                      $rt = $_SESSION['rt'];
                      $rw = $_SESSION['rw'];
                      $sql_pengumuman = "SELECT * FROM pengumuman WHERE id_rt=$rt AND id_rw = $rw ORDER BY tanggal DESC LIMIT 4";
                      $query_pengumuman = mysqli_query($koneksi,$sql_pengumuman);
                    }else if(isset($status) && $status == "sudah_login_rw"){
                      $rw = $_SESSION['rw'];
                      $sql_pengumuman = "SELECT * FROM pengumuman WHERE id_rw=$rw ORDER BY tanggal DESC LIMIT 4";
                      $query_pengumuman = mysqli_query($koneksi,$sql_pengumuman);
                    }else if(isset($status) && $status == "sudah_login_penduduk"){
                      $rt = $_SESSION['rt'];
                      $rw = $_SESSION['rw'];
                      $sql_pengumuman = "SELECT * FROM pengumuman WHERE id_rt=$rt AND id_rw = $rw ORDER BY tanggal DESC LIMIT 4";
                      $query_pengumuman = mysqli_query($koneksi,$sql_pengumuman);
                    }
                  ?>
                  <?php while($data_pengumuman = mysqli_fetch_array($query_pengumuman)):?>
                  <div class="customer-message align-items-center">
                    <a class="font-weight-bold" href="#">
                      <div class="text-truncate message-title"><?= $data_pengumuman['isi'];?></div>
                      <div class="small text-gray-500 message-time font-weight-bold"><?= $data_pengumuman['pengirim'];?> · <?= $data_pengumuman['tanggal'];?></div>
                    </a>
                  </div>
                  <?php endwhile; ?>
                  <div class="card-footer text-center">
                    <a class="m-0 small text-primary card-link" href="#">View More <i
                        class="fas fa-chevron-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--Row-->

          <!-- Modal Logout -->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Logout</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Apakah Anda yakin untuk logout ?</p>
                </div>
                <div class="modal-footer">
                  <form method="post" action=../../api/rest.php?function=logout&key=buwinakeren>
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                    <input type="hidden" name="filter" id="filter" value="1">
                    <button type="submit" class="btn btn-primary">Logout</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!---Container Fluid-->
      </div>
      
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="assets/js/ruang-admin.min.js"></script>
  <script src="assets/vendor/chart.js/Chart.min.js"></script>
  <script src="assets/js/demo/chart-area-demo.js"></script>  
</body>

</html>