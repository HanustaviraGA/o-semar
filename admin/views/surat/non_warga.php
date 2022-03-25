<?php
  include '../../../koneksi.php';
  session_start();
  if (!isset($_SESSION['keadaan'])) {
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
  <link href="../assets/img/logo/logo.png" rel="icon">
  <title>O-SEMAR - Pengajuan Surat</title>
  <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/ruang-admin.min.css" rel="stylesheet">
  <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- Select2 -->
  <link href="../assets/vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
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
            <h1 class="h3 mb-0 text-gray-800">Pengajuan Surat Non Warga</h1>
          </div>

          <!-- Row -->
          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card mb-4">
                  <div class="card-body">
                  <form action="../../controller/controller.php?aksi=tambah_surat_non_warga" method="POST" enctype="multipart/form-data">  
                  <div class="form-group">
                        <label for="select2SinglePlaceholder">Pilih Surat</label>
                        <select class="jenis form-control" name="jenis" id="jenis" onchange="yesnoCheck(this); getBerkas(this.value);">
                          <option>Pilih</option>
                          <?php 
                            $query = "SELECT * FROM jenis_surat WHERE jenis='Surat Keterangan Domisili'";
                            $exec = mysqli_query($koneksi,$query);
                          ?>
                          <?php while ($jenis = mysqli_fetch_array($exec)){ ?>
                            <option value="<?= $jenis['jenis'];?>"><?= $jenis['jenis'];?></option>
                          <?php } ?>
                          <option>Lainnya</option>
                        </select>  
                    </div>
                    <div class="form-group" id="ifYes" style="display: none;">
                      <label for="exampleInputEmail1">Silahkan Ketik Jenis Surat Anda</label>
                      <input type="text" class="form-control" name="jenis_lain" id="jenis_lain">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nama</label>
                      <input type="text" class="form-control" name="nama" id="nama">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">NIK</label>
                      <input type="text" class="form-control" name="nik" id="nik">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Tujuan</label>
                      <input type="text" class="form-control" name="tujuan" id="tujuan">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Keperluan</label>
                      <input type="text" class="form-control" name="keperluan" id="keperluan">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Keterangan</label>
                      <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
                    </div>
                    <div class="form-group" id="daftar_berkas">
                      <label for="exampleInputEmail1">Daftar Keperluan Berkas</label>
                      <textarea class="form-control" name="berkas_apa" id="berkas_apa" readonly></textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Berkas</label>
                      <button type="button" class="btn btn-primary ml-2 mb-2" id="plusInput" style="font-size: 10px"><i class="fas fa-plus"></i></button>
                      <!-- <div class="file-field1" name="berkas" id="berkas">
                        <div class="btn btn-primary btn-sm float-left">
                          <input type="file" id="files[]" name="files[]">
                        </div>
                      </div> -->
                      <div class="form-group" name="berkas" id="berkas">
                        <input type="file" id="files[]" name="files[]" class="form-control">
                      </div>
                      <div id="target">

                      </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            <?php
              $sql = "SELECT * FROM suratketerangan WHERE nama IS NOT NULL";
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
                        <th>Keperluan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Nomor Surat</th>
                        <th>Nama</th>
                        <th>Keperluan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </tfoot>
                    <tbody>
                        <?php while($data = mysqli_fetch_array($query)):?> 
                        <tr>
                          <td><?= $data['no_surat'] ?></td>
                          <td><?= $data['nama'] ?></td>
                          <td><?= $data['keperluan'] ?></td>
                          <td><?php if($data['status'] == 'Terverifikasi'){ ?>
                            <span class="badge badge-success">Terverifikasi</span>
                          <?php }else if($data['status'] == 'Pending'){?>
                            <span class="badge badge-danger">Pending</span>
                          <?php } ?></td>
                          <td><?= $data['tanggal_pengajuan'] ?></td>
                          <td>
                            <a href="detail_non?id=<?= $data['no_surat'] ?>">
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
  <!-- Select2 -->
  <script src="../assets/vendor/select2/dist/js/select2.min.js"></script>                          
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
      $('.kepentingan').select2({
        placeholder: "Pilih",
        allowClear: true
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
  <script>
    function yesnoCheck(that) {
      if (that.value == "Lainnya") {
        Swal.fire({
          title: 'Konfirmasi',
          text: "Pastikan anda mengetik jenis surat dengan jelas",
          icon: 'warning',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'OK'
        }).then((result) => {
          if (result.isConfirmed) {
              document.getElementById("ifYes").style.display = "block";
              document.getElementById("daftar_berkas").style.display = "none";
          } else if (result.isDenied) {
            document.getElementById("ifYes").style.display = "none";
            document.getElementById("daftar_berkas").style.display = "block";
          }
        })
      } else {
          document.getElementById("ifYes").style.display = "none";
          document.getElementById("daftar_berkas").style.display = "block";
      }
    }
  </script>
  <script>
    function getBerkas(val){
    //We create ajax function
      $.ajax({
        type: "POST",
        url: "list",
        data: "berkas="+val,
        success: function(data){
          $("#berkas_apa").html(data);
        }
      });
    }
  </script>
  <script>
    $('#plusInput').on('click', function () {
        var shot =
            '<div class="form-group" name="berkas" id="berkas"><input type="file" id="files[]" name="files[]" class="form-control"></div>';
        $('#target').append(shot);
    });

    function del(a) {
        a.closest('.parent').remove();
    }
  </script>
</body>

</html>