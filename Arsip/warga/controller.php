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
            $nik = $data['nik'];
            $password = $data['password'];
            $result = mysqli_query($koneksi,"SELECT * FROM warga where nik='$nik' and password='$password'");
            $cek = mysqli_num_rows($result);
            if($cek > 0) {
                $data = mysqli_fetch_assoc($result);
                //menyimpan session user, nama, status dan id login
                $_SESSION['nama_warga'] = $data['nama'];
                $_SESSION['nik'] = $data['nik'];
                if(isset($_SESSION['nama_warga']) && $_SESSION['nama_warga'] == "Guest" || $_SESSION['nama_warga'] == "guest"){
                    $_SESSION['status'] = "sudah_login_warga";
                }
                else{
                    $_SESSION['status'] = "sudah_login_warga";
                }
                $_SESSION['id_login_warga'] = $data['id'];
	            header("location:dashboard.php");
            }else {
                header("location:login.php?pesan=Data tidak ditemukan !");
            }        
        default:
        echo 'gk masuk';
            break;
    }