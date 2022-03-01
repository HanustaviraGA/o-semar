<?php
include_once '../../../../koneksi.php';
session_start();
if (!isset($_SESSION['keadaan']) && !$_SESSION['keadaan'] == "sudah_login_user") {
  header("Location: ../login");
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
  <link href="../../assets/img/icon_osemar.png" rel="icon">
  <title>O-SEMAR - Detail Penduduk</title>
  <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../../assets/css/ruang-admin.min.css" rel="stylesheet">
  <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <script src="../../assets/vendor/jquery/jquery.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <h1 class="h3 mb-0 text-gray-800">Detail Penduduk</h1>
                <ol class="breadcrumb">
                    <a href="./">Kembali</a>
                </ol>
            </div>
            <?php if(empty($_GET['id'])) {?>
                <form action="../../../controller/controller.php?aksi=update_penduduk" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6">
                    <!-- Form Basic -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="form-group">
                            <label for="exampleInputEmail1">Nomor Induk Kependudukan (NIK)</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputEmail1">Nomor Kartu Keluarga (KK)</label>
                            <input type="text" class="form-control" id="text" value="<?= $_SESSION['no_kk'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Nama</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Tempat Lahir</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Tanggal Lahir</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-lg-6">
                    <!-- General Element -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="form-group">
                            <label for="exampleInputPassword1">Alamat</label>
                            <input type="text" class="form-control" id="text" value="<?= $_SESSION['alamat'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">RT</label>
                            <input type="text" class="form-control" id="text" value="<?= $_SESSION['rt'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">RW</label>
                            <input type="text" class="form-control" id="text" value="<?= $_SESSION['rw'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Jenis Kelamin</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Agama</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-lg-6">
                    <!-- General Element -->
                    <div class="card mb-4">
                        <div class="card-body">
                            
                            <div class="form-group">
                            <label for="exampleInputPassword1">Status Perkawinan</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Pekerjaan</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Golongan Darah</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Kewarganegaraan</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-lg-6">
                    <!-- General Element -->
                    <div class="card mb-4">
                        <div class="card-body">
                            
                            <div class="form-group">
                            <label for="exampleInputPassword1">Foto KTP</label>
                            <input type="file" class="form-control" id="text">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Foto KK</label>
                            <input type="file" class="form-control" id="text">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Nomor Telepon</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Status Hubungan Keluarga</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-lg-6">
                    <!-- General Element -->
                    <div class="card mb-4">
                        <div class="card-body">
                            
                            <div class="form-group">
                            <label for="exampleInputPassword1">Nomor Paspor</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Nomor KITAS/KITAP</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Nama Ayah</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Nama Ibu</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-lg-6">
                    <!-- General Element -->
                    <div class="card mb-4">
                        <div class="card-body">
                            
                            <div class="form-group">
                            <label for="exampleInputPassword1">Pendidikan</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Tanggal Pengeluaran KK</label>
                            <input type="date" class="form-control" id="text">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Tanggal Registrasi</label>
                            <input type="date" class="form-control" id="text" value="<?= date("Y-m-d") ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Keterangan Lain</label>
                            <input type="text" class="form-control" id="text" value="-" readonly>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="form-group">
                            <label for="exampleInputPassword1">Email</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Username</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="text">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Tulis Password Kembali</label>
                            <input type="password" class="form-control" id="text">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </div>
                    </div>
                    </div>
                </form>
            <?php } else {?>
                <?php 
                    $id = $_GET['id'];
                    // Tabel Penduduk
                    $sqlNama = "SELECT * FROM penduduk WHERE nik='$id'";
                    $queryNama = mysqli_query($koneksi, $sqlNama);
                    $fetchNama = mysqli_fetch_array($queryNama);    
                ?>
                <form action="../../../controller/controller.php?aksi=update_penduduk" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6">
                    <!-- Form Basic -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="form-group">
                            <label for="exampleInputEmail1">Nomor Induk Kependudukan (NIK)</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['nik'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputEmail1">Nomor Kartu Keluarga (KK)</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['no_kk'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Nama</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['alamat'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Tempat Lahir</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['tempat_lahir'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Tanggal Lahir</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['tanggal_lahir'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-lg-6">
                    <!-- General Element -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="form-group">
                            <label for="exampleInputPassword1">Alamat</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['alamat'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">RT</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['id_rt'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">RW</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['id_rw'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Jenis Kelamin</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['jenis_kelamin'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Agama</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['agama'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-lg-6">
                    <!-- General Element -->
                    <div class="card mb-4">
                        <div class="card-body">
                            
                            <div class="form-group">
                            <label for="exampleInputPassword1">Status Perkawinan</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['status_perkawinan'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Pekerjaan</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['pekerjaan'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Golongan Darah</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['gol_darah'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Kewarganegaraan</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['kewarganegaraan'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-lg-6">
                    <!-- General Element -->
                    <div class="card mb-4">
                        <div class="card-body">
                            
                            <div class="form-group">
                            <label for="exampleInputPassword1">Foto KTP</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['foto_ktp'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Foto KK</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['foto_kk'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Nomor Telepon</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['no_hp'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Status Hubungan Keluarga</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['status_hubungan_keluarga'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-lg-6">
                    <!-- General Element -->
                    <div class="card mb-4">
                        <div class="card-body">
                            
                            <div class="form-group">
                            <label for="exampleInputPassword1">Nomor Paspor</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['no_paspor'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Nomor KITAS/KITAP</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['no_kitas'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Nama Ayah</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['nama_ayah'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Nama Ibu</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['nama_ibu'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-lg-6">
                    <!-- General Element -->
                    <div class="card mb-4">
                        <div class="card-body">
                            
                            <div class="form-group">
                            <label for="exampleInputPassword1">Pendidikan</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['pendidikan'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Tanggal Pengeluaran KK</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['tanggal_pengeluaran_kk'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Tanggal Registrasi</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['tanggal_reg'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Keterangan Lain</label>
                            <input type="text" class="form-control" id="text" value="-" readonly>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="form-group">
                            <label for="exampleInputPassword1">Email</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['email'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Username</label>
                            <input type="text" class="form-control" id="text" value="<?= $fetchNama['username'] ?>" readonly>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Tulis Password Kembali</label>
                            <input type="text" class="form-control" id="text">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </div>
                    </div>
                    </div>
                </form>
            <?php } ?>
            
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
                    <form method="post" action=../../../../api/rest.php?function=logout&key=buwinakeren>
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

  
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../../assets/js/ruang-admin.min.js"></script>
  <!-- Page level plugins -->
  <script src="../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable({
        "language": {
          "url": "../../assets/vendor/Indonesian.json"
        }
      }); // ID From dataTable 
      $('#dataTableHover').DataTable({
        "language": {
          "url": "../../assets/vendor/Indonesian.json"
        }
      }); // ID From dataTable with Hover
    });
  </script>
  <script>
    $(document).ready(function () {
      $('#dataTables').DataTable({
        "language": {
          "url": "../../assets/vendor/Indonesian.json"
        }
      }); // ID From dataTable 
      $('#dataTableHovers').DataTable({
        "language": {
          "url": "../../assets/vendor/Indonesian.json"
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