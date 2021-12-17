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
        case 'tambah_rt':
            $rt = $data['rt'];
            $rw = $data['rw'];
            $nik = $data['nik'];
            // Cek Nama Pejabat
            $nama = "SELECT * FROM penduduk WHERE nik='$nik'";
            $query_nama = mysqli_query($koneksi, $nama) or die(mysqli_error($koneksi));
            $data_nama = mysqli_fetch_array($query_nama);
            $nama_pejabat = $data_nama['nama'];
            // Eksekusi
            $sql = "INSERT INTO msrt (id_rt, id_rw, nik_ketuart, nama_rt) VALUES ('$rt', '$rw', '$nik', '$nama_pejabat')";
            $query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
            if($query){
                header("Location: list_rt.php?pesan=Sukses !");
                exit;
            }
            break;
        case 'update_rt':
            $rt = $data['id_rt'];
            $nik = $data['nik'];
            // Cek Nama Pejabat
            $nama = "SELECT * FROM penduduk WHERE nik='$nik'";
            $query_nama = mysqli_query($koneksi, $nama) or die(mysqli_error($koneksi));
            $data_nama = mysqli_fetch_array($query_nama);
            $nama_pejabat = $data_nama['nama'];
            // Eksekusi
            $sql = "UPDATE msrt SET nik_ketuart='$nik', nama_rt='$nama_pejabat' WHERE id_rt='$rt'";
            $query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
            if($query){
                header("Location: list_rt.php?pesan=Sukses !");
                exit;
            }
            break;
        case 'tambah_rw':
            $rw = $data['rw'];
            $kelurahan = $data['kelurahan'];
            $nik = $data['nik'];
            // Cek Nama Pejabat
            $nama = "SELECT * FROM penduduk WHERE nik='$nik'";
            $query_nama = mysqli_query($koneksi, $nama) or die(mysqli_error($koneksi));
            $data_nama = mysqli_fetch_array($query_nama);
            $nama_pejabat = $data_nama['nama'];
            // Eksekusi
            $sql = "INSERT INTO msrw(id_rw, id_kelurahan, nik_ketuarw, nama_rw) VALUES ('$rw', '$kelurahan', '$nik', '$nama_pejabat')";
            $query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
            if($query){
                header("Location: list_rw.php?pesan=Sukses !");
                exit;
            }
            break;
        case 'update_rw':
            $rw = $data['id_rw'];
            $nik = $data['nik'];
            // Cek Nama Pejabat
            $nama = "SELECT * FROM penduduk WHERE nik='$nik'";
            $query_nama = mysqli_query($koneksi, $nama) or die(mysqli_error($koneksi));
            $data_nama = mysqli_fetch_array($query_nama);
            $nama_pejabat = $data_nama['nama'];
            // Eksekusi
            $sql = "UPDATE msrw SET nik_ketuarw='$nik', nama_rw='$nama_pejabat' WHERE id_rw='$rw'";
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