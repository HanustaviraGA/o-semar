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
    $sql = "SELECT * FROM pengumuman";
    $query = mysqli_query($koneksi,$sql);
  }else if(isset($status) && $status == "sudah_login_rt"){
    $rt = $_SESSION['rt'];
    $rw = $_SESSION['rw'];
    $sql = "SELECT * FROM pengumuman WHERE id_rt=$rt AND id_rw = $rw";
    $query = mysqli_query($koneksi,$sql);
  }else if(isset($status) && $status == "sudah_login_rw"){
    $rw = $_SESSION['rw'];
    $sql = "SELECT * FROM pengumuman WHERE id_rw=$rw";
    $query = mysqli_query($koneksi,$sql);
  }else if(isset($status) && $status == "sudah_login_penduduk"){
    $rt = $_SESSION['rt'];
    $rw = $_SESSION['rw'];
    $sql = "SELECT * FROM pengumuman WHERE id_rt=$rt AND id_rw = $rw";
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
  <title>O-SEMAR Admin - List Pembayaran</title>
  <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/ruang-admin.min.css" rel="stylesheet">
  <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- sidebar -->
    <?php 
      include '../layout/sidebar.php';
    ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php 
          include '../layout/navbar.php';
        ?>
        <!-- Topbar -->
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pengumuman Warga</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Refresh</a></li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <?php if($_SESSION["keadaan"] == "sudah_login_admin" || $_SESSION["keadaan"] == "sudah_login_rt" || $_SESSION["keadaan"] == "sudah_login_rw"){ ?>
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card mb-4">
                  <div class="card-body">
                  <form action="../../controller/controller.php?aksi=tambah_pengumuman" method="POST" enctype="multipart/form-data">  
                    <div class="form-group">
                      <label for="exampleInputEmail1">Perihal</label>
                      <input type="text" class="form-control" name="perihal" id="perihal">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nama</label>
                      <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $_SESSION['nama_admin']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">NIK</label>
                      <input type="text" class="form-control" name="nik" id="nik" value="<?php echo $_SESSION['nik']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Keterangan</label>
                      <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Berkas</label>
                      <button type="button" class="btn btn-primary ml-2 mb-2" id="plusInput" style="font-size: 10px"><i class="fas fa-plus"></i></button>
                      
                      <div class="file-field1" name="berkas" id="berkas">
                        <div class="btn btn-primary btn-sm float-left">
                          <input type="file" id="files[]" name="files[]">
                        </div>
                      </div>
                      <div id="target">

                      </div>
                      <br>
                    <br>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            <?php } ?>
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>Kode</th>
                        <th>Perihal</th>
                        <th>Tanggal</th>
                        <th>RT</th>
                        <th>RW</th>
                        <th>Pengirim</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Kode</th>
                        <th>Perihal</th>
                        <th>Tanggal</th>
                        <th>RT</th>
                        <th>RW</th>
                        <th>Pengirim</th>
                        <th>Aksi</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php while($data = mysqli_fetch_array($query)):?>
                        <tr>
                          <td><?= $data['id'] ?></td>
                          <td><?= $data['pengumuman'] ?></td>
                          <td><?= $data['tanggal'] ?></td>
                          <td><?= $data['id_rt'] ?></td>
                          <td><?= $data['id_rw'] ?></td>
                          <td><?= $data['pengirim'] ?></td>
                          <td>
                            <a href="detail.php?id=<?= $data['id'] ?>">
                              <button class="btn btn-primary">Detail</button>
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

  <script src="../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../assets/js/ruang-admin.min.js"></script>
  <!-- Page level plugins -->
  <script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>
  <script>
    $('#plusInput').on('click', function () {
        var shot =
            '<div class="file-field1" name="berkas1" id="berkas1"><div class="btn btn-primary btn-sm float-left"><input type="file" id="files[]" name="files[]"></div></div>';
        $('#target').append(shot);
    });

    function del(a) {
        a.closest('.parent').remove();
    }
  </script>

</body>

</html>