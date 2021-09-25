<?php
    include "../koneksi.php";
    session_start();
    
    $data = $_REQUEST;

    switch($data['aksi']){
        case 'login' :
            $username = $data['username'];
            $password = $data['password'];
            $tingkatan = $data['tingkatan'];
            $result = mysqli_query($koneksi,"SELECT * FROM admin where username='$username' and password='$password'");
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
                $_SESSION['id_login'] = $data['id'];
	            header("location:index.php");
            }else {
                header("location:login.php?pesan=Data tidak ditemukan !");
            }
            break;
        case 'register':
            $nama = $_POST['nama'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $c_password = $_POST['c_password'];
            $ubah_nama = mysqli_real_escape_string($koneksi, $nama);
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
            break;
        case 'logout' :
            // mengaktifkan session
            session_start();
            
            $_SESSION['keadaan'] = "belum_login_user";
            
            // mengalihkan halaman login
            header("location:login.php?pesan=Anda telah berhasil logout");        
        default:
        echo 'gk masuk';
            break;
    }