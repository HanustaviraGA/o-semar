<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/logo.png" rel="icon">
  <title>RuangAdmin - Pendaftaran</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
  <!-- Register Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Pendaftaran</h1>
                  </div>
                  <form action="controller.php?aksi=register" method="POST">
                    <div class="form-group">
                      <label>NIK</label>
                      <input type="text" class="form-control" name="nik" id="nik" placeholder="Masukan NIK Anda">
                    </div>
                    <div class="form-group">
                      <label>Nama Lengkap</label>
                      <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukan Nama Lengkap Anda">
                    </div>
                    <div class="form-group">
                      <label>Kata Sandi</label>
                      <input type="password" class="form-control" name="password" id="password" placeholder="Masukan Kata Sandi">
                    </div>
                    <div class="form-group">
                      <label>Konfirmasi Kata Sandi</label>
                      <input type="password" class="form-control" name="c_password" id="c_password"
                        placeholder="Ulangi Kata Sandi yang Telah Anda Masukan">
                    </div>
                    <div class="form-group">
                      <label>Nomor KK</label>
                      <input type="text" class="form-control" name="kk" id="kk" placeholder="Masukan Nomot KK">
                    </div>
                    <div class="form-group">
                      <label>Nama Pengguna</label>
                      <input type="text" class="form-control" name="username" id="username" placeholder="Bukan Nama Asli">
                    </div>
                    <div class="form-group">
                      <label>Alamat</label>
                      <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Masukan Alamat Lengkap Anda">
                    </div>
                    <div class="form-group">
                      <label>TTL</label>
                      <input type="text" class="form-control" name="ttl" id="ttl" placeholder="Tempat dan Tanggal Lahir">
                    </div>
                    <div class="form-group">
                      <label>Jenis Kelamin</label>
                      <input type="text" class="form-control" name="gender" id="gender" placeholder="Laki-laki / Perempuan">
                    </div>
                    <div class="form-group">
                      <label>Posisi dalam Keluarga</label>
                      <input type="text" class="form-control" name="posisi" id="posisi" placeholder="Posisi Dalam Keluarga">
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                    </div>
                    <hr>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="font-weight-bold small" href="login.html">Already have an account?</a>
                  </div>
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Register Content -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
</body>

</html>