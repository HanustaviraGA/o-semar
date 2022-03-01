<?php
  include_once '../../../koneksi.php';
  session_start();
  if (!isset($_SESSION['keadaan'])) {
    header("Location: ../login");
    exit;
  }
  // Status login
  $status = $_SESSION['keadaan'];
  if(isset($status) && $status == "sudah_login_admin"){
    $sql = "SELECT * FROM tagihan";
    $query = mysqli_query($koneksi,$sql);
  }else if(isset($status) && $status == "sudah_login_rt"){
    $rt = $_SESSION['rt'];
    $rw = $_SESSION['rw'];
    $sql = "SELECT * FROM tagihan WHERE id_rt=$rt AND id_rw = $rw";
    $query = mysqli_query($koneksi,$sql);
  }else if(isset($status) && $status == "sudah_login_rw"){
    $rw = $_SESSION['rw'];
    $sql = "SELECT * FROM tagihan WHERE id_rw=$rw";
    $query = mysqli_query($koneksi,$sql);
  }else if(isset($status) && $status == "sudah_login_penduduk"){
    $nik = $_SESSION['nik'];
    $sql = "SELECT * FROM tagihan WHERE nik = $nik";
    $query = mysqli_query($koneksi,$sql);
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
  <link href="../assets/img/icon_osemar.png" rel="icon">
  <title>O-SEMAR - Daftar Iuran</title>
  <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/ruang-admin.min.css" rel="stylesheet">
  <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- Select2 -->
  <link href="../assets/vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
  <!-- O-Semar CSS -->
  <link href="../assets/css/ruang-admin.min.css" rel="stylesheet">
  <!-- Bootstrap DatePicker -->  
  <link href="../assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" >
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
            <h1 class="h3 mb-0 text-gray-800">Pembayaran Iuran</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Refresh</a></li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
          <?php if($_SESSION["keadaan"] == "sudah_login_admin" || $_SESSION["keadaan"] == "sudah_login_rt" || $_SESSION["keadaan"] == "sudah_login_rw"){ ?>
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card mb-4">
                  <div class="card-body">
                  <form action="../../controller/controller.php?aksi=tambah_iuran" method="POST" enctype="multipart/form-data">  
                    <div class="form-group">
                      <label for="exampleInputEmail1">Perihal Pembayaran</label>
                      <input type="text" class="form-control" name="perihal" id="perihal">
                    </div>
                    <?php 
                      if(isset($status) && $status == "sudah_login_rt"){
                        $rt = $_SESSION['rt'];
                        $rw = $_SESSION['rw'];
                        $query_penduduk = "SELECT * FROM penduduk WHERE id_rt=$rt AND id_rw = $rw";
                        $data_penduduk = mysqli_query($koneksi, $query_penduduk);
                      }else if(isset($status) && $status == "sudah_login_rw"){
                        $rw = $_SESSION['rw'];
                        $query_penduduk = "SELECT * FROM penduduk WHERE id_rw=$rw";
                        $data_penduduk = mysqli_query($koneksi, $query_penduduk);
                      }else if(isset($status) && $status == "sudah_login_admin"){
                        $query_penduduk = "SELECT * FROM penduduk";
                        $data_penduduk = mysqli_query($koneksi, $query_penduduk);
                      }
                    ?> 
                    <div class="form-group">
                        <label for="select2SinglePlaceholder">NIK - Nama</label>
                        <select class="nik form-control" name="nik" id="nik">
                          <option>Pilih</option>
                        <?php while($result_pnd = mysqli_fetch_array($data_penduduk)):?>  
                          <option value="<?= $result_pnd['nik'] ?>"><?= $result_pnd['nik'] ?> - <?= $result_pnd['nama'] ?></option>
                        <?php endwhile; ?>  
                        </select>  
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Sejumlah (Rp.)</label>
                      <input type="text" class="form-control" name="nominal" id="nominal">
                    </div>
                    <div class="form-group" id="simple-date1">
                    <label for="simpleDataInput">Tanggal Jatuh Tempo</label>
                      <div class="input-group date">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <input type="text" class="form-control" name="tanggal" id="tanggal" placeholder="Silahkan pilih tanggal">
                    </div>
                      <div class="form-group">
                      <label for="exampleInputEmail1">Rekening Pembayaran</label>
                      <input type="text" class="form-control" name="rekening" id="rekening">
                    </div>
                  </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            <?php } ?>
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>Nama</th>
                        <th>Perihal</th>
                        <th>Jatuh Tempo</th>
                        <th>Status Pembayaran</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Nama</th>
                        <th>Perihal</th>
                        <th>Jatuh Tempo</th>
                        <th>Status Pembayaran</th>
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
                          <td><?= $data['jenis_tagihan'] ?></td>
                          <td><?= $data['jatuh_tempo'] ?></td>
                          <td><?php if($data['status_pembayaran'] == 'Paid'){ ?>
                            <span class="badge badge-success">Lunas</span>
                          <?php }else if($data['status_pembayaran'] == 'Unpaid'){?>
                            <span class="badge badge-danger">Belum Terbayar</span>
                          <?php } ?></td>
                          <td>
                            <a href="detail?id=<?= $data['id_tagihan'] ?>">
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
  <!-- Bootstrap Datepicker -->
  <script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
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
  <script>
    $(document).ready(function () {


      $('.select2-single').select2();

      // Select2 Single  with Placeholder
      $('.nik').select2({
        placeholder: "Pilih NIK - Nama Ketua RT",
        allowClear: true
      });

      // Bootstrap Date Picker
      $('#simple-date1 .input-group.date').datepicker({
        format: 'yyyy/mm/dd',
        todayBtn: 'linked',
        todayHighlight: true,
        autoclose: true,        
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