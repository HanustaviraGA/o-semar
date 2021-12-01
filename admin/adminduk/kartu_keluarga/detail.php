<?php
  include '../../../koneksi.php';
  session_start();
  if (!isset($_SESSION['keadaan']) && !$_SESSION['keadaan'] == "sudah_login_user") {
    header("Location: ../login.php");
    exit;
  }
    $id = $_GET['id'];
    // Tabel Penduduk
    $sqlNama = "SELECT * FROM penduduk WHERE no_kk='$id'";
    $queryNama = mysqli_query($koneksi,$sqlNama);
    // Tabel Penduduk 2
    $sqlNama2 = "SELECT * FROM penduduk WHERE no_kk='$id'";
    $queryNama2 = mysqli_query($koneksi,$sqlNama2);
    // Wilayah
    $sqlWil = "SELECT * FROM mssettings WHERE identifier='1'";
    $queryWil = mysqli_query($koneksi,$sqlWil);
    $dataWil = mysqli_fetch_array($queryWil);
    // Identitas Kepala Keluarga
    $sqlNamaKK = "SELECT * FROM penduduk WHERE no_kk='$id' AND kepala_keluarga=1";
    $queryNamaKK = mysqli_query($koneksi,$sqlNamaKK);
    $dataNamaKK = mysqli_fetch_array($queryNamaKK);
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
  <title>O-SEMAR Admin - KK No. <?php echo $id; ?></title>
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../../css/ruang-admin.min.css" rel="stylesheet">
  <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- sidebar -->
    <?php 
      include '../../layout/sidebar-adminduk.php';
    ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php 
          include '../../layout/navbar-adminduk.php';
        ?>
        <!-- Topbar -->
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Kartu Keluarga No. <?php echo $id; ?></h1>
            <ol class="breadcrumb">
              <a href="berkas/<?php echo $dataNamaKK['foto_kk']; ?>">
                <button class="btn btn-primary">Foto KK</button>
              </a>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-body">
                  <form>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nama Kepala Keluarga</label>
                      <input type="text" class="form-control" id="text"  value="<?= $dataNamaKK['nama'] ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Alamat</label>
                      <input type="text" class="form-control" id="text" value="<?= $dataNamaKK['alamat'] ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">RT / RW</label>
                      <input type="text" class="form-control" id="text" value="<?= $dataNamaKK['id_rt'] ?> / <?= $dataNamaKK['id_rw'] ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Desa / Kelurahan</label>
                      <input type="text" class="form-control" id="text" value="<?= $dataWil['nama_kelurahan'] ?>" readonly>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <!-- General Element -->
              <div class="card mb-4">
                <div class="card-body">
                  <form>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Kecamatan</label>
                      <input type="text" class="form-control" id="text" value="<?= $dataWil['nama_kecamatan'] ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Kabupaten / Kota</label>
                      <input type="text" class="form-control" id="text" value="<?= $dataWil['nama_kabkota'] ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Kode Pos</label>
                      <input type="text" class="form-control" id="text" value="<?= $dataWil['kode_pos'] ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Provinsi</label>
                      <input type="text" class="form-control" id="text" value="<?= $dataWil['nama_provinsi'] ?>" readonly>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!--Row-->
          <!-- DataTable with Hover -->
          <div class="col-lg-12">
            <div class="card mb-4">
              <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                  <thead class="thead-light">
                    <tr>
                      <th>No</th>
                      <th>Nama Lengkap</th>
                      <th>NIK</th>
                      <th>Jenis Kelamin</th>
                      <th>Tempat Lahir</th>
                      <th>Tanggal Lahir</th>
                      <th>Pendidikan</th>
                      <th>Jenis Pekerjaan</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Nama Lengkap</th>
                      <th>NIK</th>
                      <th>Jenis Kelamin</th>
                      <th>Tempat Lahir</th>
                      <th>Tanggal Lahir</th>
                      <th>Pendidikan</th>
                      <th>Jenis Pekerjaan</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  <?php $a = 1; while($dataNama2 = mysqli_fetch_array($queryNama2)):?>
                    <tr>
                      <td><?= $a++ ?></td>
                      <td><?= $dataNama2['nama'] ?></td>
                      <td><?= $dataNama2['nik'] ?></td>
                      <td><?= $dataNama2['jenis_kelamin'] ?></td>
                      <td><?= $dataNama2['tempat_lahir'] ?></td>
                      <td><?= $dataNama2['tanggal_lahir'] ?></td>
                      <td><?= $dataNama2['pendidikan'] ?></td>
                      <td><?= $dataNama2['pekerjaan'] ?></td>
                    </tr>
                  <?php endwhile; ?>  
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="card mb-4">
              <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHovers">
                  <thead class="thead-light">
                    <tr>
                      <th>No</th>
                      <th>Status Pernikahan</th>
                      <th>Status Hubungan Dalam Keluarga</th>
                      <th>Kewarganegaraan</th>
                      <th>No. Paspor</th>
                      <th>No. KITAS/KITAP</th>
                      <th>Nama Ayah</th>
                      <th>Nama Ibu</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Status Pernikahan</th>
                      <th>Status Hubungan Dalam Keluarga</th>
                      <th>Kewarganegaraan</th>
                      <th>No. Paspor</th>
                      <th>No. KITAS/KITAP</th>
                      <th>Nama Ayah</th>
                      <th>Nama Ibu</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  <?php $a = 1; while($dataNama = mysqli_fetch_array($queryNama)):?>
                    <tr>
                      <td><?= $a++ ?></td>
                      <td><?= $dataNama['status_perkawinan'] ?></td>
                      <td><?= $dataNama['status_hubungan_keluarga'] ?></td>
                      <td><?= $dataNama['kewarganegaraan'] ?></td>
                      <td><?= $dataNama['no_paspor'] ?></td>
                      <td><?= $dataNama['no_kitas'] ?></td>
                      <td><?= $dataNama['nama_ayah'] ?></td>
                      <td><?= $dataNama['nama_ibu'] ?></td>
                    </tr>
                  <?php endwhile; ?>  
                  </tbody>
                </table>
              </div>
            </div>
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
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                  <a href="../../controller.php?aksi=logout" class="btn btn-primary">Logout</a>
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

  <script src="../../vendor/jquery/jquery.min.js"></script>
  <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../../js/ruang-admin.min.js"></script>
  <!-- Page level plugins -->
  <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>
  <script>
    $(document).ready(function () {
      $('#dataTables').DataTable(); // ID From dataTable 
      $('#dataTableHovers').DataTable(); // ID From dataTable with Hover
    });
  </script>

</body>

</html>