<?php
  include '../../koneksi.php';
  session_start();
  if (!isset($_SESSION['keadaan'])) {
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
            <h1 class="h3 mb-0 text-gray-800">Pengajuan Surat</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Refresh</a></li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
          <?php if($_SESSION["keadaan"] == "sudah_login_admin"){ ?>
            <!-- DataTable with Hover -->
            <?php 
              $sql = "SELECT * FROM suratketerangan";
              $query = mysqli_query($koneksi,$sql);
            ?>
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>Nomor Surat</th>
                        <th>Nama</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Nomor Surat</th>
                        <th>Nama</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </tfoot>
                    <tbody>
                        <?php while($data = mysqli_fetch_array($query)):?> 
                        <tr>
                          <td><?= $data['no_surat'] ?></td>
                          <td><?= $data['nama'] ?></td>
                          <td><?= $data['tujuan'] ?></td>
                          <td><?= $data['tanggal_pengajuan'] ?></td>
                          <td>
                            <a href="detail.php?id=<?= $data['no_surat'] ?>">
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
          <?php } elseif($_SESSION["keadaan"] == "sudah_login_penduduk") { ?>
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card mb-4">
                  <div class="card-body">
                  <form action="tambah.php" method="POST" enctype="multipart/form-data">  
                  <div class="form-group">
                        <label for="select2SinglePlaceholder">Pilih Surat</label>
                        <select class="jenis form-control" name="jenis" id="jenis" onchange="yesnoCheck(this);">
                          <option>Pilih</option>
                          <option value="Surat Keterangan Tidak Mampu">Surat Keterangan Tidak Mampu</option>
                          <option value="Surat Keterangan Usaha">Surat Keterangan Usaha</option>
                          <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
                          <option value="Surat Keterangan Belum Menikah">Surat Keterangan Belum Menikah</option>
                          <option value="Surat Pengantar KTP">Surat Pengantar KTP</option>
                          <option value="Surat Pengantar Akta Kelahiran">Surat Pengantar Akta Kelahiran</option>
                          <option value="Surat Pengantar Nikah">Surat Pengantar Nikah</option>
                          <option value="Surat Pengantar Cerai">Surat Pengantar Cerai</option>
                          <option>Lainnya</option>
                        </select>  
                    </div>
                    <div class="form-group" id="ifYes" style="display: none;">
                      <label for="exampleInputEmail1">Silahkan Ketik Jenis Surat Anda</label>
                      <input type="text" class="form-control" name="jenis" id="jenis">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nama</label>
                      <input type="text" class="form-control" id="nama" value="<?php echo $_SESSION['nama_admin']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">NIK</label>
                      <input type="text" class="form-control" id="nik" value="<?php echo $_SESSION['nik']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Keperluan</label>
                      <input type="text" class="form-control" id="keperluan">
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
            <?php
              $nik = $_SESSION['nik']; 
              $sql = "SELECT * FROM suratketerangan WHERE nik=$nik";
              $query = mysqli_query($koneksi,$sql);
            ?>
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>Kode Pengajuan</th>
                        <th>Jenis Surat</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Kode Pengajuan</th>
                        <th>Jenis Surat</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                      </tr>
                    </tfoot>
                    <tbody>
                        <?php while($data = mysqli_fetch_array($query)):?> 
                        <tr>
                          <td><?= $data['no_surat'] ?></td>
                          <td><?= $data['nama'] ?></td>
                          <td><?= $data['tujuan'] ?></td>
                          <td><?= $data['tanggal_pengajuan'] ?></td>
                          <td>
                            <a href="detail.php?id=<?= $data['no_surat'] ?>">
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
          <?php } elseif($_SESSION["keadaan"] == "sudah_login_rt") { ?>
            <?php
              $wil_rt = $_SESSION['rt'];
              $sql = "SELECT * FROM suratketerangan WHERE id_rt = $wil_rt";
              $query = mysqli_query($koneksi,$sql);
            ?>
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>Nomor Surat</th>
                        <th>Nama</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Nomor Surat</th>
                        <th>Nama</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </tfoot>
                    <tbody>
                        <?php while($data = mysqli_fetch_array($query)):?> 
                        <tr>
                          <td><?= $data['no_surat'] ?></td>
                          <td><?= $data['nama'] ?></td>
                          <td><?= $data['tujuan'] ?></td>
                          <td><?= $data['tanggal_pengajuan'] ?></td>
                          <td>
                            <a href="detail.php?id=<?= $data['no_surat'] ?>">
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
          <?php } elseif($_SESSION["keadaan"] == "sudah_login_rw") { ?>
            <?php
              $wil_rw = $_SESSION['rw'];
              $sql = "SELECT * FROM suratketerangan WHERE id_rw = $wil_rw";
              $query = mysqli_query($koneksi,$sql);
            ?>
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>Nomor Surat</th>
                        <th>Nama</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Nomor Surat</th>
                        <th>Nama</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </tfoot>
                    <tbody>
                        <?php while($data = mysqli_fetch_array($query)):?> 
                        <tr>
                          <td><?= $data['no_surat'] ?></td>
                          <td><?= $data['nama'] ?></td>
                          <td><?= $data['tujuan'] ?></td>
                          <td><?= $data['tanggal_pengajuan'] ?></td>
                          <td>
                            <a href="detail.php?id=<?= $data['no_surat'] ?>">
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
          <?php } ?>  
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
                  <a href="../controller.php?aksi=logout" class="btn btn-primary">Logout</a>
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
      $('.kepentingan').select2({
        placeholder: "Pilih",
        allowClear: true
      });

    });
  </script>
  <script>
    function yesnoCheck(that) {
    if (that.value == "Lainnya") {
    alert("Pastikan anda mengetik jenis surat dengan jelas");
        document.getElementById("ifYes").style.display = "block";
    } else {
        document.getElementById("ifYes").style.display = "none";
    }
}
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