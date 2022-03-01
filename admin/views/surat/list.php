<?php
    include '../../../koneksi.php';
    // Keperluan
    if (!empty($_POST["berkas"])) {
        $jenis = $_POST["berkas"]; 
        $query="SELECT * FROM jenis_surat WHERE jenis='$jenis'";
        $results = mysqli_query($koneksi, $query);

        while($jenis = mysqli_fetch_array($results)){
            echo $jenis['daftar_lampiran'];
        }

    }
?>