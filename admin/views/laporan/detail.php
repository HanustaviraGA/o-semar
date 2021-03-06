<?php
  include '../../../koneksi.php';
  session_start();
  if (!isset($_SESSION['keadaan']) && !$_SESSION['keadaan'] == "sudah_login_user") {
    header("Location: ../login");
    exit;
  }
    $id = $_GET['id'];
    $sqlID = "SELECT * FROM pelaporan WHERE id_pelaporan='$id'";
    $queryID = mysqli_query($koneksi,$sqlID);
    $dataID = mysqli_fetch_array($queryID);
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
  <title>O-SEMAR - Laporan No. <?= $id ?></title>
  <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/ruang-admin.min.css" rel="stylesheet">
  <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
            <h1 class="h3 mb-0 text-gray-800">Pelaporan</h1>
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
                  <h6 class="m-0 font-weight-bold text-primary">Detail Laporan - <?= $dataID['id_pelaporan'] ?></h6>
                </div>
                <div class="card mb-4">
                  <div class="card-body">
                    <form action = "../../controller/controller.php?aksi=bayar_laporan" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Nama Pelapor</label>
                        <input type="text" class="form-control" value="<?= $dataID['nik'] ?>" readonly>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Kategori Laporan</label>
                        <input type="text" class="form-control" value="<?= $dataID['kategori'] ?>" readonly>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Keterangan Laporan</label>
                        <input type="text" class="form-control" value="<?= $dataID['keterangan'] ?>" readonly>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Tanggal Laporan</label>
                        <input type="text" class="form-control" value="<?= $dataID['tanggal_pelaporan'] ?>" readonly>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Status Laporan</label>
                        <input type="text" class="form-control" value="<?= $dataID['status'] ?>" readonly>
                      </div>
                    </form>
                    <?php if($_SESSION['keadaan'] == "sudah_login_admin" || $_SESSION['keadaan'] == "sudah_login_rt" || $_SESSION['keadaan'] == "sudah_login_rw"){?>
                      <br>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Tindak Lanjut</button>
                    <?php } else{ ?>

                    <?php } ?>
                    
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Keterangan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <label for="message-text" class="col-form-label">Status</label>
                            <select class="form-control" name="status" id="status" onchange="yesnoCheck(this);">
                              <option value="Diterima">Diterima</option>
                              <option value="Ditolak">Ditolak</option>
                            </select>
                            <div id="diterima">
                              <form action="../../controller/controller.php?aksi=verifikasi_laporan" method="POST">
                                <label for="message-text" class="col-form-label">Lampiran</label>
                                <?php 
                                  $kode_lampiran = $id;
                                  $querykodeLampiran = "SELECT lampiran FROM lampiran WHERE kode = '$kode_lampiran'";
                                  $lampiran_kode_exec = mysqli_query($koneksi, $querykodeLampiran); 
                                ?>
                                <select class="form-control" name="lampiran" id="lampiran">
                                  <?php while($fetch_kode = mysqli_fetch_array($lampiran_kode_exec)){ ?>
                                    <option value=<?= $fetch_kode['lampiran']?>><?= $fetch_kode['lampiran']?></option>
                                  <?php } ?>
                                </select>
                                <div class="modal-footer">
                                  <input type="hidden" name="id" id="id" value="<?= $id ?>">
                                  <div>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                  </div>
                                </div>
                              </form>
                            </div>
                            <div id="ditolak" style="display: none;">
                              <form action="../../controller/controller.php?aksi=tolak_laporan" method="POST">
                              <label for="message-text" class="col-form-label">Lampiran</label>
                                <?php 
                                  $kode_lampiran = $id;
                                  $querykodeLampiran = "SELECT lampiran FROM lampiran WHERE kode = '$kode_lampiran'";
                                  $lampiran_kode_exec = mysqli_query($koneksi, $querykodeLampiran); 
                                ?>
                                <select class="form-control" name="lampiran" id="lampiran">
                                  <?php while($fetch_kode = mysqli_fetch_array($lampiran_kode_exec)){ ?>
                                    <option value=<?= $fetch_kode['lampiran']?>><?= $fetch_kode['lampiran']?></option>
                                  <?php } ?>
                                </select>
                                <div class="form-group">
                                  <label for="message-text" class="col-form-label">Tulis Keterangan Penolakan</label>
                                  <input class="form-control" id="alasan" name="alasan"></input>
                                </div>
                                <div class="modal-footer">
                                  <input type="hidden" name="id" id="id" value="<?= $id ?>">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                  <button type="submit" class="btn btn-danger">Submit</button>
                                </div>
                              </form>
                            </div>
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
                        <td>
                          <a href="../../berkas/laporan/<?= $res_lampiran['lampiran'] ?>" class="btn btn-primary" target="_blank">Unduh</a>
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
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
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
          <!-- Modal Center -->
          <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                  <script>
                    PDFObject.embed("berkas/dosen.pdf", "#pdf");
                  </script>
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

  
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../assets/js/ruang-admin.min.js"></script>
  <!-- Page level plugins -->
  <script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable({
        "language": {
          "url": "../assets/vendor/Indonesian.json"
        }
      }); // ID From dataTable 
      $('#dataTableHover').DataTable({
        "language": {
          "url": "../assets/vendor/Indonesian.json"
        }
      }); // ID From dataTable with Hover
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