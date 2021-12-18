<?php
  include '../../koneksi.php';
  session_start();
  if (!isset($_SESSION['keadaan']) && !$_SESSION['keadaan'] == "sudah_login_user") {
    header("Location: ../login.php");
    exit;
  }
    $id = $_GET['id'];
    $sqlID = "SELECT * FROM msrw WHERE id_rw='$id'";
    $queryID = mysqli_query($koneksi,$sqlID);
    $dataID = mysqli_fetch_array($queryID);

    $nik = $dataID['nik_ketuarw']; 
    $sqlNama = "SELECT nama FROM penduduk WHERE nik='$nik'";
    $queryNama = mysqli_query($koneksi,$sqlNama);
    $dataNama = mysqli_fetch_array($queryNama);

    $kelurahan = $dataID['id_kelurahan'];
    $sqlKelurahan = "SELECT nama_kelurahan FROM mskelurahan WHERE id_kelurahan='$kelurahan'";
    $queryKelurahan = mysqli_query($koneksi,$sqlKelurahan);
    $dataKelurahan = mysqli_fetch_array($queryKelurahan);
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
  <!-- O-Semar CSS -->
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
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="list_rw.php">Kembali</a></li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Detail RW - <?= $dataID['id_rw'] ?></h6>
                </div>
                <div class="card mb-4">
                <div class="card-body">
                  <form action="controller.php?aksi=update_rw" method="post">
                    <div class="form-group">
                      <label for="exampleInputEmail1">ID RW</label>
                      <input type="text" class="form-control" value="<?= $dataID['id_rw'] ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Kelurahan</label>
                      <input type="text" class="form-control" value="<?= $dataID['id_kelurahan'] ?> - <?= $dataKelurahan['nama_kelurahan'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="select2SinglePlaceholder">NIK Ketua RW</label>
                        <select class="nik form-control" name="nik" id="nik">
                        <?php 
                            $sqlPenduduk = "SELECT * FROM penduduk";
                            $queryPenduduk = mysqli_query($koneksi,$sqlPenduduk);
                        ?>
                        <?php while($dataPenduduk = mysqli_fetch_array($queryPenduduk)):?>
                            <option value="<?= $dataPenduduk['nik'] ?>"><?= $dataPenduduk['nik'] ?></option>
                        <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="select2SinglePlaceholder">Nama RW</label>
                        <select class="nama form-control" name="nama" id="nama">
                        <?php 
                            $sqlPenduduk = "SELECT * FROM penduduk";
                            $queryPenduduk = mysqli_query($koneksi,$sqlPenduduk);
                        ?>
                        <?php while($dataPenduduk = mysqli_fetch_array($queryPenduduk)):?>
                            <option value="<?= $dataPenduduk['nama'] ?>"><?= $dataPenduduk['nama'] ?></option>
                        <?php endwhile; ?>
                        </select>
                    </div>
                  <br>
                  <button type="submit" class="btn btn-primary" style="background-color:#77dd77; border-color:#77dd77;">Update</button>
                  </form>
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
                  <form method="post" action=../../api/rest.php?function=logout&key=buwinakeren>
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                    <input type="hidden" name="filter" id="filter" value="1">
                    <button type="submit" class="btn btn-primary">Logout</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Center -->
          <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalCenterTitle">Modal Vertically Centered</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div id="pdf" class="modal-body">
                  <script src="pdfobject.js"></script>
                  <script>PDFObject.embed("berkas/dosen.pdf", "#pdf");</script>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
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
  <!-- Select2 -->
  <script src="../vendor/select2/dist/js/select2.min.js"></script>
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
      $('.nik').select2({
        placeholder: "Pilih NIK",
        allowClear: true
      });
      // Select2 Single  with Placeholder
      $('.nama').select2({
        placeholder: "Pilih Nama Ketua RW",
        allowClear: true
      });
    });
  </script>
</body>

</html>