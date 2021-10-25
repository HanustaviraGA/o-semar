<?php
  include '../../koneksi.php';
  session_start();
  if (!isset($_SESSION['keadaan']) && !$_SESSION['keadaan'] == "sudah_login_user") {
    header("Location: ../login.php");
    exit;
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
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../css/ruang-admin.min.css" rel="stylesheet">
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- Select2 -->
  <link href="../vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
  <!-- RuangAdmin CSS -->
  <link href="../css/ruang-admin.min.css" rel="stylesheet">
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
            <h1 class="h3 mb-0 text-gray-800">Pengaturan Wilayah</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Refresh</a></li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Atur sesuai dengan wilayah kerja Anda</h6>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="controller.php?aksi=update" method="POST">
                            <div class="form-group">
                                <label for="select2SinglePlaceholder">Provinsi</label>
                                <select class="provinsi form-control" name="provinsi" id="provinsi">
                                <?php 
                                    $sqlProvinsi = "SELECT * FROM msprovinsi";
                                    $queryProvinsi = mysqli_query($koneksi,$sqlProvinsi);
                                ?>
                                <?php while($dataProvinsi = mysqli_fetch_array($queryProvinsi)):?>
                                    <option value="<?= $dataProvinsi['id_provinsi'] ?>"><?= $dataProvinsi['id_provinsi'] ?> - <?= $dataProvinsi['nama_provinsi'] ?></option>
                                <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Kabupaten / Kota</label>
                                <select class="kabkota form-control" name="kabkota" id="kabkota">
                                <?php 
                                    $sqlKabkota = "SELECT * FROM mskabkota";
                                    $queryKabkota = mysqli_query($koneksi,$sqlKabkota);
                                ?>
                                <?php while($dataKabkota = mysqli_fetch_array($queryKabkota)):?>
                                    <option value="<?= $dataKabkota['id_kabkota'] ?>"><?= $dataKabkota['id_kabkota'] ?> - <?= $dataKabkota['nama_kabkota'] ?></option>
                                <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Kecamatan</label>
                                <select class="kecamatan form-control" name="kecamatan" id="kecamatan">
                                <?php 
                                    $sqlKecamatan = "SELECT * FROM mskecamatan";
                                    $queryKecamatan = mysqli_query($koneksi,$sqlKecamatan);
                                ?>
                                <?php while($dataKecamatan = mysqli_fetch_array($queryKecamatan)):?>
                                    <option value="<?= $dataKecamatan['id_kecamatan'] ?>"><?= $dataKecamatan['id_kecamatan'] ?> - <?= $dataKecamatan['nama_kecamatan'] ?></option>
                                <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Desa / Kelurahan</label>
                                <select class="kelurahan form-control" name="desa_kelurahan" id="desa_kelurahan">
                                <?php 
                                    $sqlKelurahan = "SELECT * FROM mskelurahan";
                                    $queryKelurahan = mysqli_query($koneksi,$sqlKelurahan);
                                ?>
                                <?php while($dataKelurahan = mysqli_fetch_array($queryKelurahan)):?>
                                    <option value="<?= $dataKelurahan['id_kelurahan'] ?>"><?= $dataKelurahan['id_kelurahan'] ?> - <?= $dataKelurahan['nama_kelurahan'] ?></option>
                                <?php endwhile; ?>    
                                </select>
                            </div>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </form>
                    </div>
                </div>
                  <!-- batas -->
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
                  <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                  <a href="login.html" class="btn btn-primary">Logout</a>
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

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/ruang-admin.min.js"></script>
  <!-- Page level plugins -->
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="../vendor/select2/dist/js/select2.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>

  <!-- RuangAdmin Javascript -->
  <script src="js/ruang-admin.min.js"></script>
  <!-- Javascript for this page -->
  <script>
    $(document).ready(function () {


      $('.select2-single').select2();

      // Select2 Single  with Placeholder
      $('.provinsi').select2({
        placeholder: "Pilih Provinsi",
        allowClear: true
      });
      // Select2 Single  with Placeholder
      $('.kabkota').select2({
        placeholder: "Pilih Kabupaten / Kota",
        allowClear: true
      });
      // Select2 Single  with Placeholder
      $('.kecamatan').select2({
        placeholder: "Pilih Kecamatan",
        allowClear: true
      });
      // Select2 Single  with Placeholder
      $('.kelurahan').select2({
        placeholder: "Pilih Desa / Kelurahan",
        allowClear: true
      });         

    });
  </script>

</body>

</html>