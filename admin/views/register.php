<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="assets/img/logo/logo.png" rel="icon">
  <title>O-Semar - Pendaftaran</title>
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="assets/css/ruang-admin.min.css" rel="stylesheet">

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
                  <form action="../../api/rest.php?function=register&key=buwinakeren" method="POST">
                    <div class="form-group">
                      <label>Nomor KK</label>
                      <input type="text" class="form-control" name="no_kk" id="no_kk" placeholder="Masukan Nomor KK Anda" required>
                    </div>
                    <div class="form-group">
                      <label>NIK</label>
                      <input type="text" class="form-control" name="nik" id="nik" placeholder="Masukan NIK Anda" required>
                    </div>
                    <div class="form-group">
                      <label>Nama Lengkap</label>
                      <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukan Nama Lengkap Anda" required>
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" name="email" id="email" placeholder="Masukan Alamat Email Anda" required>
                    </div>
                    <div class="form-group">
                      <label>Nama Pengguna</label>
                      <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan Nama Pengguna Anda" required>
                    </div>
                    <div class="form-group">
                      <label>Kata Sandi</label>
                      <input type="password" class="form-control" name="password" id="password" placeholder="Masukan Kata Sandi" required>
                    </div>
                    <div class="form-group">
                      <label>Konfirmasi Kata Sandi</label>
                      <input type="password" class="form-control" name="c_password" id="c_password"
                        placeholder="Ulangi Kata Sandi yang Telah Anda Masukan" required>
                    </div>
                    <div class="form-group">
                      <input type="hidden" name="filter" id="filter" value="1" required>
                      <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                    </div>
                    <hr>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="font-weight-bold small" href="login.php">Sudah memiliki akun ? Klik disini</a>
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
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="assets/js/ruang-admin.min.js"></script>
  <script>
    var password = document.getElementById("password")
  , confirm_password = document.getElementById("c_password");

    function validatePassword(){
      if(password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Kata sandi tidak sama");
      } else {
        confirm_password.setCustomValidity('');
      }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
  </script>
</body>

</html>