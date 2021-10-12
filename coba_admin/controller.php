<?php
    include "../koneksi.php";
    session_start();
    
    $data = $_REQUEST;

    switch($data['aksi']){
        case 'login' :
            // mengaktifkan session php
            session_start();
            // menghubungkan dengan koneksi
            include '../koneksi.php';
            $username = $data['username'];
            $password = $data['password'];
            $result = mysqli_query($koneksi,"SELECT * FROM penduduk where username='$username' and password='$password'");
            $cek = mysqli_num_rows($result);
            if($cek > 0) {
                $data = mysqli_fetch_assoc($result);
                //menyimpan session user, nama, status dan id login
                $_SESSION['nama_admin'] = $data['nama'];
                $_SESSION['user_admin'] = $data['username'];
                if(isset($_SESSION['nama_admin']) && $_SESSION['nama_admin'] == "Guest" || $_SESSION['nama_admin'] == "guest"){
                    $_SESSION['keadaan'] = "sudah_login_guest";
                }
                else{
                    $_SESSION['keadaan'] = "sudah_login_user";
                }
                $_SESSION['id_login'] = $data['nik'];
	            header("location:index.php");
            }else {
                header("location:login.php?pesan=Data tidak ditemukan !");
            }
            break;
        case 'register':
            $nama = $data['nama'];
            $username = $data['username'];
            $password = $data['password'];
            $c_password = $data['c_password'];
            $kk = $data['kk'];
            $alamat = $data['alamat'];
            $ttl = $data['ttl'];
            $gender = $data['gender'];
            $posisi = $data['posisi'];
            $ubah_nama = mysqli_real_escape_string($koneksi, $nama);

            if($password != $c_password){
                header("location:register.php?pesan=Konfirmasi password harus sama dengan password !");
                exit;
            }
            if((!empty($ubah_nama)) && (!empty($username)) && (!empty($password))){
                $query = mysqli_query($koneksi,"INSERT INTO `admin` (`nama`, `username`, `password`, `no_kk`, `alamat`, `ttl` ,`gender`, `posisi` ) VALUES ('$ubah_nama', '$username', '$password', '$kk', '$alamat', '$ttl', '$gender', '$posisi');");
                header("location:register.php?pesan=Pendaftaran Berhasil !");
            }
            else{
                header("location:register.php?pesan=Maaf, tidak boleh ada field yang kosong !");
            }
            break;
        case 'logout' :
            // mengaktifkan session
            session_start();
            // $_SESSION['keadaan'] = "belum_login_user";
            unset($_SESSION['keadaan']);
            // mengalihkan halaman login
            header("location:login.php?pesan=Anda telah berhasil logout");        
        default:
        echo 'gk masuk';
            break;
    }