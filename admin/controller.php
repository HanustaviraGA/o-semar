<?php
    include "../koneksi.php";
    session_start();
    
    $data = $_REQUEST;

    switch($data['aksi']){
        case 'login' :
            // menghubungkan dengan koneksi
            include '../koneksi.php';
            $username = $data['username'];
            $password = $data['password'];
            $esc_pw = mysqli_real_escape_string($koneksi, $password);
            $hash_pw = hash('sha256', $esc_pw);
            $result = mysqli_query($koneksi,"SELECT * FROM penduduk where username='$username' and password='$hash_pw'");
            $cek = mysqli_num_rows($result);
            if($cek > 0) {
                $identitas = mysqli_fetch_assoc($result);
                //menyimpan session user, nama, status dan id login
                $_SESSION['nik'] = $identitas['nik'];
                $ceknik = $identitas['nik'];

                $rt = mysqli_query($koneksi,"SELECT * FROM msrt where nik_ketuart='$ceknik'");
                $cekrt = mysqli_num_rows($rt);
                $rw = mysqli_query($koneksi,"SELECT * FROM msrw where nik_ketuarw='$ceknik'");
                $cekrw = mysqli_num_rows($rw);
                $SA = mysqli_query($koneksi,"SELECT * FROM msadmin where nik='$ceknik'");
                $cekSA = mysqli_num_rows($SA);
                // RT
                if($cekrt > 0 && $cekrw == 0 && $cekSA != 1){
                    $_SESSION['nama_admin'] = $identitas['nama'];
                    $_SESSION['user_admin'] = $identitas['username'];
                    $_SESSION['nik'] = $identitas['nik'];
                    $_SESSION['no_kk'] = $identitas['no_kk'];
                    $_SESSION['rt'] = $identitas['id_rt'];
                    $_SESSION['rw'] = $identitas['id_rw'];
                    $_SESSION['keadaan'] = "sudah_login_rt";
                }
                // RW
                else if($cekrt == 0 && $cekrw > 0 && $cekSA != 1){
                    $_SESSION['nama_admin'] = $identitas['nama'];
                    $_SESSION['user_admin'] = $identitas['username'];
                    $_SESSION['nik'] = $identitas['nik'];
                    $_SESSION['no_kk'] = $identitas['no_kk'];
                    $_SESSION['rt'] = $identitas['id_rt'];
                    $_SESSION['rw'] = $identitas['id_rw'];
                    $_SESSION['keadaan'] = "sudah_login_rw";
                }
                else if($cekrt == 0 && $cekrw == 0 && $cekSA != 1){
                    $_SESSION['nama_admin'] = $identitas['nama'];
                    $_SESSION['user_admin'] = $identitas['username'];
                    $_SESSION['nik'] = $identitas['nik'];
                    $_SESSION['no_kk'] = $identitas['no_kk'];
                    $_SESSION['rt'] = $identitas['id_rt'];
                    $_SESSION['rw'] = $identitas['id_rw'];
                    $_SESSION['keadaan'] = "sudah_login_penduduk";
                }
                else if($cekrt == 0 && $cekrw == 0 && $cekSA == 1){
                    $_SESSION['nama_admin'] = $identitas['nama'];
                    $_SESSION['user_admin'] = $identitas['username'];
                    $_SESSION['nik'] = $identitas['nik'];
                    $_SESSION['no_kk'] = $identitas['no_kk'];
                    $_SESSION['rt'] = $identitas['id_rt'];
                    $_SESSION['rw'] = $identitas['id_rw'];
                    $_SESSION['keadaan'] = "sudah_login_admin";
                }
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
            $esc_pw = mysqli_real_escape_string($koneksi, $password);
            $esc_pwc = mysqli_real_escape_string($koneksi, $c_password);
            $hash_pw = hash('sha256', $esc_pw);
            $hash_pwc = hash('sha256', $esc_pwc);
            $kk = $data['kk'];
            $alamat = $data['alamat'];
            $ttl = $data['ttl'];
            $gender = $data['gender'];
            $posisi = $data['posisi'];
            $ubah_nama = mysqli_real_escape_string($koneksi, $nama);

            if($hash_pw != $hash_pwc){
                header("location:register.php?pesan=Konfirmasi password harus sama dengan password !");
                exit;
            }
            if((!empty($ubah_nama)) && (!empty($username)) && (!empty($hash_pw))){
                $query = mysqli_query($koneksi,"INSERT INTO `admin` (`nama`, `username`, `password`, `no_kk`, `alamat`, `ttl` ,`gender`, `posisi` ) VALUES ('$ubah_nama', '$username', '$hash_pw', '$kk', '$alamat', '$ttl', '$gender', '$posisi');");
                header("location:register.php?pesan=Pendaftaran Berhasil !");
            }
            else{
                header("location:register.php?pesan=Maaf, tidak boleh ada field yang kosong !");
            }
            break;
        case 'logout' :
            // $_SESSION['keadaan'] = "belum_login_user";
            unset($_SESSION['keadaan']);
            // mengalihkan halaman login
            header("location:login.php?pesan=Anda telah berhasil logout");        
        default:
        echo 'gk masuk';
            break;
    }