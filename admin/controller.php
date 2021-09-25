<?php
    include "../../koneksi.php";
    session_start();
    
    $data = $_REQUEST;

    switch($data['aksi']){
        case '1' :
            $id = $data['id'];
            $respon_user = $data['respon_user'];
            $respon_avery = $data['respon_avery'];
            $ubah_respon_user = mysqli_real_escape_string($koneksi, $respon_user);
            $ubah_respon_avery = mysqli_real_escape_string($koneksi, $respon_avery);
            $query = mysqli_query($koneksi,"INSERT INTO `pertanyaan_pttkk` (`respon`, `pertanyaan`) VALUES ('$ubah_respon_user', '$ubah_respon_avery');") or die(mysqli_error($koneksi));
            if($query){
                header("Location: finansial.php?pesan=Sukses Mengubah Data Admin !");
                exit;
            }
            break;
        case '2':
            $id = $data['id'];
            $respon_user = $data['respon_user'];
            $respon_avery = $data['respon_avery'];
            $ubah_respon_user = mysqli_real_escape_string($koneksi, $respon_user);
            $ubah_respon_avery = mysqli_real_escape_string($koneksi, $respon_avery);
            $query = mysqli_query($koneksi,"INSERT INTO `pertanyaan_administrasi` (`respon`, `pertanyaan`) VALUES ('$ubah_respon_user', '$ubah_respon_avery');") or die(mysqli_error($koneksi));
            if($query){
                header("Location: finansial.php?pesan=Sukses Mengubah Data Admin !");
                exit;
            }
            break;
        case 'hapus' :
            $id = $data['id'];
            $sql = "DELETE FROM admin WHERE id='$id'";
            $query = mysqli_query($koneksi, $sql);
            if($query){
                header("Location: admins.php?pesan=Sukses");
                exit;
            }    
            break;        
        default:
        echo 'gk masuk';
            break;
    }