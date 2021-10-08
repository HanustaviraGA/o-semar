<?php
    include "../../koneksi.php";
    session_start();

    $data = $_REQUEST;

    switch($data['aksi']){
        case 'verifikasi' :
            $id = $data['id'];
            $new = "Terverifikasi";
            $sql = "UPDATE iuran SET status='$new', catatan='' WHERE id='$id'";
            $query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
            if($query){
                header("Location: index.php?pesan=Sukses !");
                exit;
            }
            break;
        case 'tolak':
            $id = $data['id'];
            $new = "Ditolak";
            $catatan = $data['alasan'];
            $sql = "UPDATE iuran SET status='$new', catatan='$catatan' WHERE id='$id'";
            $query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
            if($query){
                header("Location: index.php?pesan=Sukses !");
                exit;
            }
            break;
        default:
        echo 'gk masuk';
            break;
    }
?>