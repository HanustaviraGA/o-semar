<?php
  include '../../../koneksi.php';
  session_start();
  if (!isset($_SESSION['keadaan'])) {
    header("Location: ../login.php");
    exit;
  }
  // Status login
  $status = $_SESSION['keadaan'];
  if(isset($status) && $status == "sudah_login_admin"){
    $sql = "SELECT * FROM penduduk";
    $query = mysqli_query($koneksi,$sql);
  }else if(isset($status) && $status == "sudah_login_rt"){
    $rt = $_SESSION['rt'];
    $rw = $_SESSION['rw'];
    $sql = "SELECT * FROM penduduk WHERE id_rt = $rt AND id_rw = $rw";
    $query = mysqli_query($koneksi,$sql);
  }else if(isset($status) && $status == "sudah_login_rw"){
    $rw = $_SESSION['rw'];
    $sql = "SELECT * FROM penduduk WHERE id_rw = $rw";
    $query = mysqli_query($koneksi,$sql);
  }else if(isset($status) && $status == "sudah_login_penduduk"){
    $nik = $_SESSION['nik'];
    $sql = "SELECT * FROM penduduk WHERE nik = $nik";
    $query = mysqli_query($koneksi,$sql);
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
  <link href="img/logo/logo.png" rel="icon">
  <title>O-SEMAR Admin - List Pengajuan</title>
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../../css/ruang-admin.min.css" rel="stylesheet">
  <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- sidebar -->
    <?php 
      include '../../layout/sidebar-adminduk.php';
    ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php 
          include '../../layout/navbar-adminduk.php';
        ?>
        <!-- Topbar -->
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <?php if(isset($status) && $status == "sudah_login_admin"){ ?>
              <h1 class="h3 mb-0 text-gray-800">Daftar Penduduk</h1>
            <?php } else if(isset($status) && $status == "sudah_login_rt"){ ?>
              <h1 class="h3 mb-0 text-gray-800">Daftar Penduduk RT <?php echo $rt; ?> / RW <?php echo $rw; ?></h1>
            <?php } else if(isset($status) && $status == "sudah_login_rw"){ ?>
              <h1 class="h3 mb-0 text-gray-800">Daftar Penduduk RW <?php echo $rw; ?></h1>
            <?php } else if(isset($status) && $status == "sudah_login_penduduk"){ ?>
              <h1 class="h3 mb-0 text-gray-800">Forbidden</h1>
            <?php } ?>  
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Refresh</a></li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>RT</th>
                        <th>RW</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>RT</th>
                        <th>RW</th>
                        <th>Aksi</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php while($data = mysqli_fetch_array($query)):?>
                        <tr>
                          <td><?= $data['nik']?></td>
                          <td><?= $data['nama']?></td>
                          <td><?= $data['id_rt']?></td>
                          <td><?= $data['id_rw']?></td>
                          <td>
                            <a href="detail.php">
                              <button class="btn btn-primary" type="submit">Detail</button>
                            </a>
                          </td>
                        </tr>
                      <?php endwhile; ?>
                    </tbody>
                  </table>
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
                  <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer">
                  <form method="post" action=../../../api/rest.php?function=logout&key=buwinakeren>
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

  <script src="../../vendor/jquery/jquery.min.js"></script>
  <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../../js/ruang-admin.min.js"></script>
  <!-- Page level plugins -->
  <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>

</body>

</html>