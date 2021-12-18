<?php
    include_once "../../../koneksi.php";
    session_start();

    $data = $_REQUEST;

    switch($data['aksi']){
        case 'tambah' :
            $perihal = $data['perihal'];
            $nik = $data['nik'];
            $nominal = $data['nominal'];
            $tanggal = $data['tanggal'];
            $rekening = $data['rekening'];
            // Default value
            $prefix = 'SRT';
            $uniqid = uniqid($prefix);
            // Cek Nama Penduduk
            $nama = "SELECT * FROM penduduk WHERE nik='$nik'";
            $query_nama = mysqli_query($koneksi, $nama) or die(mysqli_error($koneksi));
            $data_nama = mysqli_fetch_array($query_nama);
            $nama_penduduk = $data_nama['nama'];
            $rt_penduduk = $data_nama['id_rt'];
            $rw_penduduk = $data_nama['id_rw'];
            // Eksekusi
            $sql = "INSERT INTO tagihan(id_tagihan, nik, id_rt, id_rw, jenis_tagihan, total_tagihan, jatuh_tempo, status_pembayaran, rekening, bukti_pembayaran, tanggal_pembayaran) 
            VALUES ('$uniqid', '$nik', '$rt_penduduk', '$rw_penduduk', '$perihal', $nominal, '$tanggal', 'Unpaid', '$rekening', '-', '-')";
            $query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
            if($query){
                header("Location: index.php?pesan=Sukses !");
                exit;
            }
            break;
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