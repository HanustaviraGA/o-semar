<?php
  include '../../koneksi.php';
  session_start();
  if (!isset($_SESSION['keadaan']) && !$_SESSION['keadaan'] == "sudah_login_user") {
    header("Location: ../login.php");
    exit;
  }
    $id = $_GET['id'];
    $sqlID = "SELECT * FROM tagihan WHERE id_tagihan='$id'";
    $queryID = mysqli_query($koneksi,$sqlID);
    $dataID = mysqli_fetch_array($queryID);

    $nik = $dataID['nik']; 
    $sqlNama = "SELECT nama FROM penduduk WHERE nik='$nik'";
    $queryNama = mysqli_query($koneksi,$sqlNama);
    $dataNama = mysqli_fetch_array($queryNama);
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
              <li class="breadcrumb-item"><a href="./">Kembali</a></li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Detail Iuran - <?= $dataNama['nama'] ?></h6>
                </div>
                <div class="card mb-4">
                <div class="card-body">
                  <form>
                    <div class="form-group">
                      <label for="exampleInputEmail1">NIK Pembayar</label>
                      <input type="text" class="form-control" value="<?= $dataID['nik'] ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nama Pembayar</label>
                      <input type="text" class="form-control" value="<?= $dataNama['nama'] ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Jenis Tagihan</label>
                      <input type="text" class="form-control" value="<?= $dataID['jenis_tagihan'] ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Total Tagihan</label>
                      <input type="text" class="form-control" value="<?= $dataID['total_tagihan'] ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Jatuh Tempo</label>
                      <input type="text" class="form-control" value="<?= $dataID['jatuh_tempo'] ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Status Pembayaran</label>
                      <input type="text" class="form-control" value="<?= $dataID['status_pembayaran'] ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Bukti Pembayaran</label>
                      <input type="text" class="form-control" value="<?= $dataID['bukti_pembayaran'] ?>" readonly>
                    </div>
                    <div>
                        <input type="hidden" name="aksi" value="bukti">
                        <input type="hidden" name="file" value="<?= $dataID['bukti_pembayaran'] ?>">
                        <button class="btn btn-primary">Download Bukti</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter"
                          id="#modalCenter">Preview</button>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Tanggal Pembayaran</label>
                      <input type="text" class="form-control" value="<?= $dataID['tanggal_pembayaran'] ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Nomor VA</label>
                      <input type="text" class="form-control" value="<?= $dataID['rekening'] ?>" readonly>
                    </div>
                  <br>
                  </form>
                  <a href="controller.php?aksi=verifikasi&id=<?= $dataID['id_tagihan'] ?>">
                    <button class="btn btn-primary" style="background-color:#77dd77; border-color:#77dd77;">Verifikasi</button>
                  </a>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style="background-color:#ff6961; border-color:#ff6961;">Tolak</button>
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
            <div class="col-lg-12">
              <div class="card mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Lampiran</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>No</th>
                        <th>Nama Lampiran</th>
                        <th>Status Lampiran</th>
                        <th>Keterangan Lampiran</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>No</th>
                        <th>Nama Lampiran</th>
                        <th>Status Lampiran</th>
                        <th>Keterangan Lampiran</th>
                        <th>Aksi</th>
                      </tr>
                    </tfoot>
                    <tbody>
                    <?php 
                      $lampiran = $id;
                      $queryLampiran = "SELECT lampiran, status_lampiran, ket_lampiran FROM lampiran WHERE kode = '$lampiran'";
                      $lampiran_exec = mysqli_query($koneksi, $queryLampiran); 
                    ?>
                    <?php $a = 1; while($res_lampiran = mysqli_fetch_array($lampiran_exec)):?>
                      <tr>
                        <td><?= $a++ ?></td>
                        <td><?= $res_lampiran['lampiran'] ?></td>
                        <td><?= $res_lampiran['status_lampiran'] ?></td>
                        <td><?= $res_lampiran['ket_lampiran'] ?></td>
                        <td>DUMMY</td>
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

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/ruang-admin.min.js"></script>
  <!-- Page level plugins -->
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>

</body>

</html>