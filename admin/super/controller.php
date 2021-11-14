<?php
    include "../../koneksi.php";
    session_start();
    
    $data = $_REQUEST;

    switch($data['aksi']){
        case 'update' :
            // Kode Wilayah
            $provinsi = $data['provinsi'];
            $kabkota = $data['kabkota'];
            $kecamatan = $data['kecamatan'];
            $kelurahan = $data['desa_kelurahan'];
            // Nama Wilayah
            $nama_provinsi = "SELECT * FROM msprovinsi WHERE id_provinsi='$provinsi'";
            $nama_kabkota = "SELECT * FROM mskabkota WHERE id_kabkota='$kabkota'";
            $nama_kecamatan = "SELECT * FROM mskecamatan WHERE id_kecamatan='$kecamatan'";
            $nama_kelurahan = "SELECT * FROM mskelurahan WHERE id_kelurahan='$kelurahan'";

            $query_provinsi = mysqli_query($koneksi, $nama_provinsi) or die(mysqli_error($koneksi));
            $query_kabkota = mysqli_query($koneksi, $nama_kabkota) or die(mysqli_error($koneksi));
            $query_kecamatan = mysqli_query($koneksi, $nama_kecamatan) or die(mysqli_error($koneksi));
            $query_kelurahan = mysqli_query($koneksi, $nama_kelurahan) or die(mysqli_error($koneksi));

            $dataProvinsi = mysqli_fetch_array($query_provinsi);
            $dataKabkota = mysqli_fetch_array($query_kabkota);
            $dataKecamatan = mysqli_fetch_array($query_kecamatan);
            $dataKelurahan = mysqli_fetch_array($query_kelurahan);

            $currentProv = $dataProvinsi['nama_provinsi'];
            $currentKota = $dataKabkota['nama_kabkota'];
            $currentKec = $dataKecamatan['nama_kecamatan'];
            $currentKel = $dataKelurahan['nama_kelurahan'];

            $sql = "UPDATE mssettings SET 
            id_provinsi='$provinsi',
            nama_provinsi='$currentProv', 
            id_kabkota='$kabkota',
            nama_kabkota='$currentKota', 
            id_kecamatan='$kecamatan',
            nama_kecamatan='$currentKec', 
            id_kelurahan='$kelurahan',
            nama_kelurahan='$currentKel' 
            WHERE identifier='1'";
            $query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
            if($query){
                header("Location: pengaturan.php?pesan=Sukses !");
                exit;
            }
            break;
        case 'update_rw':
            $nik = $data['nik'];
            $nama = $data['nama'];

            $sql = "UPDATE msrw SET nik_ketuarw='$nik', nama_rw='$nama'";
            $query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
            if($query){
                header("Location: list_rw.php?pesan=Sukses !");
                exit;
            }
            break;    
        default:
        echo 'gk masuk';
            break;
    }