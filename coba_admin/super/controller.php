<?php
    include "../../koneksi.php";
    session_start();
    
    $data = $_REQUEST;

    switch($data['aksi']){
        case 'update' :
            $provinsi = $data['provinsi'];
            $kabkota = $data['kabkota'];
            $kecamatan = $data['kecamatan'];
            $kelurahan = $data['desa_kelurahan'];
            // $ubah_nama2 = mysqli_real_escape_string($koneksi, $status);
            $sql = "UPDATE mssettings SET id_provinsi='$provinsi', id_kabkota='$kabkota', 
            id_kecamatan='$kecamatan', id_kelurahan='$kelurahan' WHERE identifier='1'";
            $query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
            if($query){
                header("Location: pengaturan.php?pesan=Sukses !");
                exit;
            }
            break;
        default:
        echo 'gk masuk';
            break;
    }