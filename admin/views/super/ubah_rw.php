<?php
  include '../../../koneksi.php';
  session_start();
  if (!isset($_SESSION['keadaan']) && !$_SESSION['keadaan'] == "sudah_login_user") {
    header("Location: ../login");
    exit;
  }
  $id = $_GET['id'];
  $sql = "SELECT * FROM msrw WHERE id_rw = '$id'";
  $query = mysqli_query($koneksi,$sql);
  $data = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="../assets/img/icon_osemar.png" rel="icon">
  <title>O-SEMAR - Ubah RW</title>
  <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/ruang-admin.min.css" rel="stylesheet">
  <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- Select2 -->
  <link href="../assets/vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
  <!-- O-Semar CSS -->
  <link href="../assets/css/ruang-admin.min.css" rel="stylesheet">
  <script src="../assets/vendor/jquery/jquery.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <h1 class="h3 mb-0 text-gray-800">Ubah RW <?= $id ?></h1>
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
                  <form action="../../controller/controller.php?aksi=update_rw" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                      <label for="exampleInputEmail1">Nomor RW</label>
                      <input type="text" class="form-control" value="<?= $data['id_rw']?>" name="rt" id="rt" readonly>
                  </div>
                  <?php
                    $kode = $data['id_kelurahan']; 
                    $nama_desa = "SELECT * FROM mskelurahan WHERE id_kelurahan='$kode'";
                    $desa_exec = mysqli_query($koneksi, $nama_desa);
                    $result_desa = mysqli_fetch_array($desa_exec);
                 ?>
                  <div class="form-group">
                      <label for="exampleInputEmail1">Nomor Kelurahan</label>
                      <input type="text" class="form-control" value="<?= $data['id_kelurahan']?> - <?= $result_desa['nama_kelurahan'] ?>" name="rw" id="rw" readonly>
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
                    <input type="hidden" name="id_rw" id="id_rw" value="<?= $id?>" required>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            <?php } ?>
            <!-- DataTable with Hover -->
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
      $('.rw').select2({
        placeholder: "Pilih RW",
        allowClear: true
      });
      // Select2 Single  with Placeholder
      $('.nik').select2({
        placeholder: "Pilih NIK Ketua RT",
        allowClear: true
      });

    });
  </script>
<?php 
  
  if(isset($_GET['pesan'])){
    $pesan = $_GET['pesan'];
    if($pesan == 'sukses'){
      echo    "<script type = 'text/javascript'>
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil !',
                  text: 'Data berhasil disimpan'
                })
                </script>";
    }else if($pesan == 'gagal'){
      echo    "<script type = 'text/javascript'>
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal !',
                  text: 'Silahkan coba lagi'
                })
                </script>";
    }
  }

  ?>
</body>

</html>