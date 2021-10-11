<?php
  include '../../koneksi.php';
  session_start();
  if (!isset($_SESSION['keadaan']) && !$_SESSION['keadaan'] == "sudah_login_user") {
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
            <h1 class="h3 mb-0 text-gray-800">Pengaturan Informasi Wilayah</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item">Tables</li>
              <li class="breadcrumb-item active" aria-current="page">DataTables</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Select2</h6>
                </div>
                <div class="card-body">        
                  <p>Select2 is a jQuery based replacement for select boxes</p>          
                  <div class="form-group">
                    <label for="select2Single">Single Select Box</label>
                    <select class="select2-single form-control" name="state" id="select2Single">
                      <option value="">Select</option>
                      <option value="Aceh">Aceh</option>
                      <option value="Sumatra Utara">Sumatra Utara</option>
                      <option value="Sumatra Barat">Sumatra Barat</option>
                      <option value="Riau">Riau</option>
                      <option value="Kepulauan Riau">Kepulauan Riau</option>
                      <option value="Jambi">Jambi</option>
                      <option value="Bengkulu">Bengkulu</option>
                      <option value="Sumatra Selatan">Sumatra Selatan</option>
                      <option value="Kepulauan Bangka Belitung">Kepulauan Bangka Belitung</option>
                      <option value="Lampung">Lampung</option>
                      <option value="Banten">Banten</option>
                      <option value="Jawa Barat">Jawa Barat</option>
                      <option value="Jakarta">Jakarta</option>
                      <option value="Jawa Tengah">Jawa Tengah</option>
                      <option value="Yogyakarta">Yogyakarta</option>
                      <option value="Jawa TImur">Jawa Timur</option>
                      <option value="Bali">Bali</option>
                      <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                      <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                      <option value="Kalimantan Barat">Kalimantan Barat</option>
                      <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                      <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                      <option value="Kalimantan Timur">Kalimantan Timur</option>
                      <option value="Kalimantan Utara">Kalimantan Utara</option>
                      <option value="Gorontalo">Gorontalo</option>
                      <option value="Sulawaesi Barat">Sulawesi Barat</option>
                      <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                      <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                      <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                      <option value="Sulawesi Utara">Sulawesi Utara</option>
                      <option value="Maluku">Maluku</option>
                      <option value="Maluku Utara">Maluku Utara</option>
                      <option value="Papua Barat">Papua Barat</option>
                      <option value="Papua">Papua</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="select2SinglePlaceholder">Single Select Box with Placeholder</label>
                    <select class="select2-single-placeholder form-control" name="state" id="select2SinglePlaceholder">
                      <option value="">Select</option>
                      <option value="Aceh">Aceh</option>
                      <option value="Sumatra Utara">Sumatra Utara</option>
                      <option value="Sumatra Barat">Sumatra Barat</option>
                      <option value="Riau">Riau</option>
                      <option value="Kepulauan Riau">Kepulauan Riau</option>
                      <option value="Jambi">Jambi</option>
                      <option value="Bengkulu">Bengkulu</option>
                      <option value="Sumatra Selatan">Sumatra Selatan</option>
                      <option value="Kepulauan Bangka Belitung">Kepulauan Bangka Belitung</option>
                      <option value="Lampung">Lampung</option>
                      <option value="Banten">Banten</option>
                      <option value="Jawa Barat">Jawa Barat</option>
                      <option value="Jakarta">Jakarta</option>
                      <option value="Jawa Tengah">Jawa Tengah</option>
                      <option value="Yogyakarta">Yogyakarta</option>
                      <option value="Jawa TImur">Jawa Timur</option>
                      <option value="Bali">Bali</option>
                      <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                      <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                      <option value="Kalimantan Barat">Kalimantan Barat</option>
                      <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                      <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                      <option value="Kalimantan Timur">Kalimantan Timur</option>
                      <option value="Kalimantan Utara">Kalimantan Utara</option>
                      <option value="Gorontalo">Gorontalo</option>
                      <option value="Sulawaesi Barat">Sulawesi Barat</option>
                      <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                      <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                      <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                      <option value="Sulawesi Utara">Sulawesi Utara</option>
                      <option value="Maluku">Maluku</option>
                      <option value="Maluku Utara">Maluku Utara</option>
                      <option value="Papua Barat">Papua Barat</option>
                      <option value="Papua">Papua</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="select2Multiple">Multiple-Select Boxes (pillbox)</label>
                    <select class="select2-multiple form-control" name="states[]" multiple="multiple"
                      id="select2Multiple">
                      <option value="">Select</option>
                      <option value="Aceh">Aceh</option>
                      <option value="Sumatra Utara">Sumatra Utara</option>
                      <option value="Sumatra Barat">Sumatra Barat</option>
                      <option value="Riau">Riau</option>
                      <option value="Kepulauan Riau" selected>Kepulauan Riau</option>
                      <option value="Jambi">Jambi</option>
                      <option value="Bengkulu">Bengkulu</option>
                      <option value="Sumatra Selatan">Sumatra Selatan</option>
                      <option value="Kepulauan Bangka Belitung">Kepulauan Bangka Belitung</option>
                      <option value="Lampung">Lampung</option>
                      <option value="Banten">Banten</option>
                      <option value="Jawa Barat" selected>Jawa Barat</option>
                      <option value="Jakarta">Jakarta</option>
                      <option value="Jawa Tengah">Jawa Tengah</option>
                      <option value="Yogyakarta">Yogyakarta</option>
                      <option value="Jawa TImur">Jawa Timur</option>
                      <option value="Bali">Bali</option>
                      <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                      <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                      <option value="Kalimantan Barat">Kalimantan Barat</option>
                      <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                      <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                      <option value="Kalimantan Timur">Kalimantan Timur</option>
                      <option value="Kalimantan Utara">Kalimantan Utara</option>
                      <option value="Gorontalo">Gorontalo</option>
                      <option value="Sulawaesi Barat">Sulawesi Barat</option>
                      <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                      <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                      <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                      <option value="Sulawesi Utara">Sulawesi Utara</option>
                      <option value="Maluku">Maluku</option>
                      <option value="Maluku Utara">Maluku Utara</option>
                      <option value="Papua Barat">Papua Barat</option>
                      <option value="Papua">Papua</option>
                    </select>
                  </div>
                  <p>For documentations Select2 you can visit <a href="https://select2.org/"
                    target="_blank">here.</a></p>
                </div>
              </div>

              <!-- Form Sizing -->
              <div class="card mb-3">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Sizing</h6>
                </div>
                <div class="card-body">
                  <p>Set heights using classes like <code class="highlighter-rouge">.form-control-lg</code> and <code
                      class="highlighter-rouge">.form-control-sm</code>.</p>
                  <p>Example for form general</p>
                  <input class="form-control form-control-lg mb-3" type="text" placeholder=".form-control-lg">
                  <input class="form-control  mb-3" type="text" placeholder="Default input">
                  <input class="form-control form-control-sm  mb-3" type="text" placeholder=".form-control-sm">
                  <p>Example for Select</p>
                  <select class="form-control form-control-lg  mb-3">
                    <option>Large select</option>
                  </select>
                  <select class="form-control mb-3">
                    <option>Default select</option>
                  </select>
                  <select class="form-control form-control-sm mb-3">
                    <option>Small select</option>
                  </select>
                </div>
              </div>

          <!-- Documentation Link -->
          <div class="row">
            <div class="col-lg-12">
              <p>DataTables is a third party plugin that is used to generate the demo table below. For more information
                about DataTables, please visit the official <a href="https://datatables.net/" target="_blank">DataTables
                  documentation.</a></p>
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
                  <a href="login.html" class="btn btn-primary">Logout</a>
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