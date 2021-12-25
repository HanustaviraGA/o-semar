<?php
  include '../../../koneksi.php';
  session_start();
  if (!isset($_SESSION['keadaan']) && !$_SESSION['keadaan'] == "sudah_login_user") {
    header("Location: ../login.php");
    exit;
  }
    $id = $_GET['id'];
    $sqlID = "SELECT * FROM msrt WHERE id_rt='$id'";
    $queryID = mysqli_query($koneksi,$sqlID);
    $dataID = mysqli_fetch_array($queryID);

    $nik = $dataID['nik_ketuart']; 
    $sqlNama = "SELECT nama FROM penduduk WHERE nik='$nik'";
    $queryNama = mysqli_query($koneksi,$sqlNama);
    $dataNama = mysqli_fetch_array($queryNama);

    $rw = $dataID['id_rw'];
    $sqlrw = "SELECT nama_rw FROM msrw WHERE id_rw='$rw'";
    $queryrw = mysqli_query($koneksi,$sqlrw);
    $datarw = mysqli_fetch_array($queryrw);
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
              <li class="breadcrumb-item"><a href="list_rt.php">Kembali</a></li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Detail RT - <?= $dataNama['id_rt'] ?></h6>
                </div>
                <div class="card mb-4">
                <div class="card-body">
                  <form>
                    <div class="form-group">
                      <label for="exampleInputEmail1">ID RT</label>
                      <input type="text" class="form-control" value="<?= $dataID['id_rt'] ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">ID RW</label>
                      <input type="text" class="form-control" value="<?= $dataNama['id_rw'] ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">NIK Ketua RT</label>
                      <select class="provinsi form-control" name="nik" id="nik">
                      <?php 
                        $sqlPenduduk = "SELECT * FROM penduduk";
                        $queryPenduduk = mysqli_query($koneksi,$sqlPenduduk);
                      ?>
                      <?php while($dataPenduduk = mysqli_fetch_array($queryPenduduk)):?>
                        <option value="<?= $dataPenduduk['nama'] ?>"><?= $dataPenduduk['nik'] ?></option>
                      <?php endwhile; ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Nama Ketua RT</label>
                      <input type="text" class="form-control" value="<?= $dataID['nama_rt'] ?>" readonly>
                    </div>
                   
                    <div>
                        <input type="hidden" name="aksi" value="bukti">
                        <input type="hidden" name="file" value="<?= $dataID['bukti_pembayaran'] ?>">
                        <button class="btn btn-primary">Download Bukti</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter"
                          id="#modalCenter">Preview</button>
                    </div>
                  <br>
                  </form>
                  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alasan Penolakan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                        <div class="modal-body">
                          <form action="controller.php?aksi=tolak&id=<?= $dataID['id'] ?>" method="POST">
                            <div class="form-group">
                              <label for="message-text" class="col-form-label">Tulis Alasan:</label>
                              <input class="form-control" id="alasan" name="alasan"></input>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak Jadi</button>
                              <button type="submit" class="btn btn-primary">Kirim Alasan</button>
                            </div>
                          </form>  
                        </div>
                          
                      
                    </div>
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
                  <form method="post" action=../../../api/rest.php?function=logout&key=buwinakeren>
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
                  <script>PDFObject.embed("../berkas/iuran/dosen.pdf", "#pdf");</script>
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

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>copyright &copy; <script> document.write(new Date().getFullYear()); </script> - developed by
              <b><a href="https://indrijunanda.gitlab.io/" target="_blank">indrijunanda</a></b>
            </span>
          </div>
        </div>
      </footer>
      <!-- Footer -->
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

</body>

</html>