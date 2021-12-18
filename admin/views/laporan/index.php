<?php
  include '../../koneksi.php';
  session_start();
  if (!isset($_SESSION['keadaan'])) {
    header("Location: ../login.php");
    exit;
  }
  $sql = "SELECT * FROM pelaporan";
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
  <title>O-SEMAR ADMIN-LAPORAN</title>
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
            <h1 class="h3 mb-0 text-gray-800">Pelaporan</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Refresh</a></li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
          <?php if($_SESSION["keadaan"] == "sudah_login_admin"){ ?>
            <!-- DataTable with Hover -->
            <?php 
              $sql = "SELECT * FROM pelaporan";
              $query = mysqli_query($koneksi,$sql);
            ?>
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>Nama Pelapor</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Nama Pelapor</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </tfoot>
                    
                    <tbody>
                    <?php while($data = mysqli_fetch_array($query)):?>
                        <tr>
                          <?php
                            $nik = $data['nik']; 
                            $sqlID = "SELECT nama FROM penduduk WHERE nik='$nik'";
                            $queryID = mysqli_query($koneksi,$sqlID);
                            $dataID = mysqli_fetch_array($queryID);
                          ?>
                          <td><?= $dataID['nama'] ?></td>
                          <td><?= $data['kategori'] ?></td>
                          <td><?= $data['tanggal_pelaporan'] ?></td>
                          <td>
                          DUMMY
                          </td>
                        </tr>
                    <?php endwhile; ?>  
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php } elseif($_SESSION["keadaan"] == "sudah_login_penduduk") { ?>
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card mb-4">
                  <div class="card-body">
                  <form action="controller.php" method="POST" enctype="multipart/form-data">  
                    <div class="form-group">
                        <label for="select2SinglePlaceholder">Pilih Kategori Laporan</label>
                        <select class="form-control" name="kategori" id="kategori" onchange="yesnoCheck(this);">
                          <option>Pilih</option>
                          <option value="Keamanan">Keamanan</option>
                          <option value="Sarana dan Prasarana">Sarana dan Prasarana</option>
                          <option value="Kebersihan">Kebersihan</option>
                          <option value="Tata Tertib">Tata Tertib</option>
                          <option>Lainnya</option>
                        </select>  
                    </div>
                    <div class="form-group" id="ifYes" style="display: none;">
                      <label for="exampleInputEmail1">Silahkan Ketik Kategori Laporan Anda</label>
                      <input type="text" class="form-control" name="kategori" id="kategori">
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
                      <label for="exampleInputEmail1">Keterangan</label>
                      <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Foto</label>
                      <button type="button" class="btn btn-primary ml-2 mb-2" id="plusInput" style="font-size: 10px"><i class="fas fa-plus"></i></button>
                      
                      <div class="file-field1" name="foto1" id="foto1">
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
              $sql = "SELECT * FROM pelaporan WHERE nik=$nik";
              $query = mysqli_query($koneksi,$sql);
            ?>
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>Nama Pelapor</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Nama Pelapor</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </tfoot>
                    
                    <tbody>
                    <?php while($data = mysqli_fetch_array($query)):?>
                        <tr>
                          <?php
                            $nik = $data['nik']; 
                            $sqlID = "SELECT nama FROM penduduk WHERE nik='$nik'";
                            $queryID = mysqli_query($koneksi,$sqlID);
                            $dataID = mysqli_fetch_array($queryID);
                          ?>
                          <td><?= $dataID['nama'] ?></td>
                          <td><?= $data['kategori'] ?></td>
                          <td><?= $data['tanggal_pelaporan'] ?></td>
                          <td>
                          DUMMY
                          </td>
                        </tr>
                    <?php endwhile; ?>  
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php } elseif($_SESSION["keadaan"] == "sudah_login_rt") { ?>
            <?php
              $wil_rt = $_SESSION['rt'];
              $sql = "SELECT * FROM pelaporan WHERE id_rt = $wil_rt";
              $query = mysqli_query($koneksi,$sql);
            ?>
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>Nama Pelapor</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Nama Pelapor</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </tfoot>
                    
                    <tbody>
                    <?php while($data = mysqli_fetch_array($query)):?>
                        <tr>
                          <?php
                            $nik = $data['nik']; 
                            $sqlID = "SELECT nama FROM penduduk WHERE nik='$nik'";
                            $queryID = mysqli_query($koneksi,$sqlID);
                            $dataID = mysqli_fetch_array($queryID);
                          ?>
                          <td><?= $dataID['nama'] ?></td>
                          <td><?= $data['kategori'] ?></td>
                          <td><?= $data['tanggal_pelaporan'] ?></td>
                          <td>
                          DUMMY
                          </td>
                        </tr>
                    <?php endwhile; ?>  
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php } elseif($_SESSION["keadaan"] == "sudah_login_rw") { ?>
            <?php
              $wil_rw = $_SESSION['rw'];
              $sql = "SELECT * FROM pelaporan WHERE id_rw = $wil_rw";
              $query = mysqli_query($koneksi,$sql);
            ?>
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>Nama Pelapor</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Nama Pelapor</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </tfoot>
                    
                    <tbody>
                    <?php while($data = mysqli_fetch_array($query)):?>
                        <tr>
                          <?php
                            $nik = $data['nik']; 
                            $sqlID = "SELECT nama FROM penduduk WHERE nik='$nik'";
                            $queryID = mysqli_query($koneksi,$sqlID);
                            $dataID = mysqli_fetch_array($queryID);
                          ?>
                          <td><?= $dataID['nama'] ?></td>
                          <td><?= $data['kategori'] ?></td>
                          <td><?= $data['tanggal_pelaporan'] ?></td>
                          <td>
                          DUMMY
                          </td>
                        </tr>
                    <?php endwhile; ?>  
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            </div>
          <?php } ?>  
          </div>


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

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>
  <script>
    function yesnoCheck(that) {
    if (that.value == "Lainnya") {
    alert("Pastikan anda mengetik kategori laporan dengan jelas");
        document.getElementById("ifYes").style.display = "block";
    } else {
        document.getElementById("ifYes").style.display = "none";
    }
}
  </script>
  <script>
    $('#plusInput').on('click', function () {
        var shot =
            '<div class="file-field1" name="foto1" id="foto1"><div class="btn btn-primary btn-sm float-left"><input type="file" id="files[]" name="files[]"></div></div>';
        $('#target').append(shot);
    });

    function del(a) {
        a.closest('.parent').remove();
    }
  </script>
</body>

</html>