<?php
  include '../../../koneksi.php';
  session_start();
  if (!isset($_SESSION['keadaan']) && !$_SESSION['keadaan'] == "sudah_login_user") {
    header("Location: ../login.php");
    exit;
  }
  $sql = "SELECT * FROM msrw";
  $query = mysqli_query($koneksi,$sql);
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
  <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/ruang-admin.min.css" rel="stylesheet">
  <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- Select2 -->
  <link href="../assets/vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
  <!-- O-Semar CSS -->
  <link href="../assets/css/ruang-admin.min.css" rel="stylesheet">
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
            <h1 class="h3 mb-0 text-gray-800">Pengaturan RW</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Refresh</a></li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <?php if($_SESSION["keadaan"] == "sudah_login_admin"){ ?>
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card mb-4">
                  <div class="card-body">
                  <form action="controller.php?aksi=tambah_rw" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                      <label for="exampleInputEmail1">Nomor RW</label>
                      <input type="text" class="form-control" name="rw" id="rw">
                  </div>
                    <?php 
                      $query_rw = "SELECT * FROM mskelurahan";
                      $data_rw = mysqli_query($koneksi, $query_rw);
                    ?>  
                    <div class="form-group">
                        <label for="select2SinglePlaceholder">Nomor Kelurahan</label>
                        <select class="kelurahan form-control" name="kelurahan" id="kelurahan">
                          <option>Pilih</option>
                        <?php while($result = mysqli_fetch_array($data_rw)):?>  
                          <option value="<?= $result['id_kelurahan'] ?>"><?= $result['id_kelurahan'] ?> - <?= $result['nama_kelurahan'] ?></option>
                        <?php endwhile; ?>  
                        </select>  
                    </div>
                    <?php 
                      $query_penduduk = "SELECT * FROM penduduk";
                      $data_penduduk = mysqli_query($koneksi, $query_penduduk);
                    ?> 
                    <div class="form-group">
                        <label for="select2SinglePlaceholder">NIK - Nama Ketua RW</label>
                        <select class="nik form-control" name="nik" id="nik">
                          <option>Pilih</option>
                        <?php while($result_pnd = mysqli_fetch_array($data_penduduk)):?>  
                          <option value="<?= $result_pnd['nik'] ?>"><?= $result_pnd['nik'] ?> - <?= $result_pnd['nama'] ?></option>
                        <?php endwhile; ?>  
                        </select>  
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
                        <th>ID RW</th>
                        <th>Desa/Kelurahan</th>
                        <th>Ketua</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>ID RW</th>
                        <th>Desa/Kelurahan</th>
                        <th>Ketua</th>
                        <th>Aksi</th>
                      </tr>
                    </tfoot>
                    
                    <tbody>
                    <?php while($data = mysqli_fetch_array($query)):?>
                        <tr>
                          <?php
                            $kode = $data['id_kelurahan']; 
                            $nama_desa = "SELECT * FROM mskelurahan WHERE id_kelurahan='$kode'";
                            $desa_exec = mysqli_query($koneksi, $nama_desa);
                            $result_desa = mysqli_fetch_array($desa_exec);
                          ?>
                          <td><?= $data ['id_rw'] ?></td>
                          <td><?= $data ['id_kelurahan'] ?> - <?= $result_desa['nama_kelurahan'] ?></td>
                          <td><?= $data ['nama_rw'] ?></td>
                          <td><a href="ubah_rw.php?id=<?= $data['id_rw'] ?>">
                                <button class="btn btn-primary">Ubah</button>    
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
  <script src="../assets/vendor/select2/dist/js/select2.min.js"></script>
  <!-- O-Semar Javascript -->
  <script src="../assets/js/ruang-admin.min.js"></script>
  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>
  <script>
    $(document).ready(function () {


      $('.select2-single').select2();

      // Select2 Single  with Placeholder
      $('.kelurahan').select2({
        placeholder: "Pilih Kelurahan",
        allowClear: true
      });
      // Select2 Single  with Placeholder
      $('.nik').select2({
        placeholder: "Pilih NIK - Nama Ketua RW",
        allowClear: true
      });

    });
  </script>

</body>

</html>