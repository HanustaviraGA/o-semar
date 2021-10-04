<?php
    include "../../koneksi.php";
    session_start();
    
    $data = $_REQUEST;

    switch($data['aksi']){
        case 'ubah' :
            $id = $data['id'];
            $log = $data['log'];
            $ubah_nama = mysqli_real_escape_string($koneksi, $log);
            $status = $data['status'];
            // $ubah_nama2 = mysqli_real_escape_string($koneksi, $status);
            $sql = "UPDATE summary SET log='$ubah_nama' WHERE nim='$id'";
            $sql2 = "UPDATE summary SET status='$status' WHERE nim='$id'";
            $query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
            $query2 = mysqli_query($koneksi, $sql2) or die(mysqli_error($koneksi));
            if($query && $query2){
                header("Location: index.php?pesan=Sukses !");
                exit;
            }
            break;
        default:
        echo 'gk masuk';
            break;
    }