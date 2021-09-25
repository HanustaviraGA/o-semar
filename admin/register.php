<?php 
// mengaktifkan session php
session_start();
 
// menghubungkan dengan koneksi
include 'koneksi.php';
 
// menangkap data yang dikirim dari form
$nama = $_POST['nama'];
$username = $_POST['username'];
$password = $_POST['password'];
$c_password = $_POST['c_password'];
$ubah_nama = mysqli_real_escape_string($koneksi, $nama);
// // menambah data
// $rowSQL = mysqli_query( "SELECT MAX( id ) AS max FROM `users`;" );
// $row = mysqli_fetch_array( $rowSQL );
// $largestNumber = $row['max'];

if($password != $c_password){
    header("location:register.php?pesan=Konfirmasi password harus sama dengan password !");
    exit;
}

if((!empty($ubah_nama)) && (!empty($username)) && (!empty($password))){
    $query = mysqli_query($koneksi,"INSERT INTO `users` (`nama`, `username`, `password`) VALUES ('$ubah_nama', '$username', '$password');");
    header("location:register.php?pesan=Pendaftaran Berhasil !");
}
else{
    header("location:register.php?pesan=Maaf, tidak boleh ada field yang kosong !");
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
  <title>RuangAdmin - Register</title>
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
                    <h1 class="h4 text-gray-900 mb-4">Register</h1>
                  </div>
                  <form>
                    <div class="form-group">
                      <label>NIK</label>
                      <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Masukan NIK Anda">
                    </div>
                    <div class="form-group">
                      <label>Nama Lengkap</label>
                      <input type="text" class="form-control" id="exampleInputLastName" placeholder="Masukan Nama Lengkap Anda">
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                        placeholder="Masukan Alamat Email Anda">
                    </div>
                    <div class="form-group">
                      <label>Kata Sandi</label>
                      <input type="password" class="form-control" id="exampleInputPassword" placeholder="Masukan Kata Sandi">
                    </div>
                    <div class="form-group">
                      <label>Konfirmasi Kata Sandi</label>
                      <input type="password" class="form-control" id="exampleInputPasswordRepeat"
                        placeholder="Ulangi Kata Sandi yang Telah Anda Masukan">
                    </div>
                    <div class="form-group">
                      <label>Nomor KK</label>
                      <input type="text" class="form-control" id="exampleInputLastName" placeholder="Masukan Nomot KK">
                    </div>
                    <div class="form-group">
                      <label>Nama Pengguna</label>
                      <input type="text" class="form-control" id="exampleInputLastName" placeholder="Bukan Nama Asli">
                    </div>
                    <div class="form-group">
                      <label>Alamat</label>
                      <input type="text" class="form-control" id="exampleInputLastName" placeholder="Masukan Alamat Lengkap Anda">
                    </div>
                    <div class="form-group">
                      <label>TTL</label>
                      <input type="text" class="form-control" id="exampleInputLastName" placeholder="Tempat dan Tanggal Lahir">
                    </div>
                    <div class="form-group">
                      <label>Jenis Kelamin</label>
                      <input type="text" class="form-control" id="exampleInputLastName" placeholder="Laki-laki / Perempuan">
                    </div>
                    <div class="form-group">
                      <label>Posisi dalam Keluarga</label>
                      <input type="text" class="form-control" id="exampleInputLastName" placeholder="Posisi Dalam Keluarga">
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                    <hr>
                    <a href="index.html" class="btn btn-google btn-block">
                      <i class="fab fa-google fa-fw"></i> Register with Google
                    </a>
                    <a href="index.html" class="btn btn-facebook btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                    </a>
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