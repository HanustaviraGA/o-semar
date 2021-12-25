<?php
    include "../../koneksi.php";
    session_start();

    $data = $_REQUEST;

    switch($data['aksi']){
        // Iuran
        case 'tambah_iuran' :
            $perihal = $data['perihal'];
            $nik = $data['nik'];
            $nominal = $data['nominal'];
            $tanggal = $data['tanggal'];
            $rekening = $data['rekening'];
            // Default value
            $prefix = 'TGHN';
            $uniqid = uniqid($prefix);
            // Cek Nama Penduduk
            $nama = "SELECT * FROM penduduk WHERE nik='$nik'";
            $query_nama = mysqli_query($koneksi, $nama) or die(mysqli_error($koneksi));
            $data_nama = mysqli_fetch_array($query_nama);
            $nama_penduduk = $data_nama['nama'];
            $rt_penduduk = $data_nama['id_rt'];
            $rw_penduduk = $data_nama['id_rw'];
            // Eksekusi
            $sql = "INSERT INTO tagihan(id_tagihan, nik, id_rt, id_rw, jenis_tagihan, total_tagihan, jatuh_tempo, status_pembayaran, rekening, bukti_pembayaran) 
            VALUES ('$uniqid', '$nik', '$rt_penduduk', '$rw_penduduk', '$perihal', $nominal, '$tanggal', 'Unpaid', '$rekening', '-')";
            $query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
            if($query){
                header("Location: ../views/iuran/index.php?pesan=Sukses !");
                exit;
            }
            break;
        case 'verifikasi_iuran' :
            $id = $data['id'];
            $new = "Terverifikasi";
            $sql = "UPDATE iuran SET status='$new', catatan='' WHERE id='$id'";
            $query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
            if($query){
                header("Location: ../views/iuran/index.php?pesan=Sukses !");
                exit;
            }
            break;
        case 'tolak_iuran':
            $id = $data['id'];
            $new = "Ditolak";
            $catatan = $data['alasan'];
            $sql = "UPDATE iuran SET status='$new', catatan='$catatan' WHERE id='$id'";
            $query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
            if($query){
                header("Location: ../views/iuran/index.php?pesan=Sukses !");
                exit;
            }
            break;
        // Laporan
        case 'tambah_laporan':
            $nik = $_SESSION['nik'];
            $rt = $_SESSION['rt'];
            $rw = $_SESSION['rw'];
            $tanggal = date("Y-m-d");
            if(isset($_POST['submit'])){
                $nama = $_POST['nama'];
                $keterangan = $_POST['keterangan'];
                $kategori = $_POST['kategori'];
                $prefix = 'LPR';
                $uniqid = uniqid($prefix);
                if(isset($_FILES["files"]) && !empty($_FILES["files"]["name"])){
                    foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
                        $file_name = $key.$_FILES['files']['name'][$key];
                        $file_size =$_FILES['files']['size'][$key];
                        $file_tmp =$_FILES['files']['tmp_name'][$key];
                        $file_type=$_FILES['files']['type'][$key];
                        
                        $original_filename = $_FILES['files']['name'][$key];
                        $ext = strtolower(pathinfo($_FILES["files"]["name"][$key], PATHINFO_EXTENSION));
                        // check extension and upload
                        if(in_array( $ext, array('jpg', 'jpeg', 'png', 'gif', 'bmp'))) {
                            $filename_without_ext = basename($original_filename, '.'.$ext);
                            $new_filename = uniqid() .  '_' . $nik . '.' . $ext;
                            move_uploaded_file($file_tmp,'../berkas/'.$new_filename);
                            // Masuk Lampiran
                            $sql = "INSERT INTO lampiran(nik, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran) 
                            VALUES('$nik', '$new_filename', 'Laporan Masyarakat', '$tanggal', 'Pending', '-')";
                            $query = mysqli_query($koneksi, $sql);
                            $sql_pelaporan = "INSERT INTO pelaporan(id_pelaporan, nik, id_rt, id_rw, kategori, keterangan, tanggal_pelaporan, status)
                            VALUES ('$uniqid', '$nik', '$rt', '$rw', '$kategori', '$keterangan', '$tanggal', 'Pending')";
                            $query_pelaporan = mysqli_query($koneksi, $sql_pelaporan);
                            header("Location: ../views/laporan/index.php?pesan=Berhasil");
                        }
                        else{
                            header("Location: ../views/laporan/index.php?pesan=Gagal");
                        }
                    }
                }else{
                    
                }
            }                  
            break;
        // Pengumuman
        case 'tambah_pengumuman':
            $nik = $_SESSION['nik'];
            $rt = $_SESSION['rt'];
            $rw = $_SESSION['rw'];
            $tanggal = date("Y-m-d");
            if(isset($_POST['submit'])){
                $nama = $_POST['nama'];
                $keterangan = $_POST['keterangan'];
                $perihal = $_POST['perihal'];
                $prefix = 'PNG';
                $uniqid = uniqid($prefix);
                if(isset($_FILES["files"]) && !empty($_FILES["files"]["name"])){
                    foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
                        $file_name = $key.$_FILES['files']['name'][$key];
                        $file_size =$_FILES['files']['size'][$key];
                        $file_tmp =$_FILES['files']['tmp_name'][$key];
                        $file_type=$_FILES['files']['type'][$key];
                        
                        $original_filename = $_FILES['files']['name'][$key];
                        $ext = strtolower(pathinfo($_FILES["files"]["name"][$key], PATHINFO_EXTENSION));
                        // check extension and upload
                        if(in_array( $ext, array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'pdf'))) {
                            $filename_without_ext = basename($original_filename, '.'.$ext);
                            $new_filename = uniqid() .  '_' . $nik . '.' . $ext;
                            move_uploaded_file($file_tmp,'../berkas/'.$new_filename);
                            // Masuk Lampiran
                            $sql = "INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran) 
                            VALUES('$nik', '$uniqid', '$new_filename', 'Pengumuman Warga', '$tanggal', 'Pending', '-')";
                            $query = mysqli_query($koneksi, $sql);
                            $sql_pelaporan = "INSERT INTO pengumuman(id, pengumuman, isi, tanggal, id_rt, id_rw, pengirim)
                            VALUES ('$uniqid', '$perihal', '$keterangan', '$tanggal', '$rt', '$rw', '$nama')";
                            $query_pelaporan = mysqli_query($koneksi, $sql_pelaporan);
                            header("Location: ../views/pengumuman/index.php?pesan=Berhasil");
                        }
                        else{
                            header("Location: ../views/pengumuman/index.php?pesan=Gagal");
                        }
                    }
                }else{
                    
                }
            }                  
            break;
        // Super
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
                header("Location: ../views/super/pengaturan.php?pesan=Sukses !");
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
                header("Location: ../views/super/list_rt.php?pesan=Sukses !");
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
                header("Location: ../views/super/list_rt.php?pesan=Sukses !");
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
                header("Location: ../views/super/list_rw.php?pesan=Sukses !");
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
                header("Location: ../views/super/list_rw.php?pesan=Sukses !");
                exit;
            }
            break;
        // Surat
        case 'tambah_surat':
            $nik = $_SESSION['nik'];
            $rt = $_SESSION['rt'];
            $rw = $_SESSION['rw'];
            $tanggal = date("Y-m-d");
            if(isset($_POST['submit'])){
                $nama = $_POST['nama'];
                $keterangan = $_POST['keterangan'];
                $jenis = $_POST['jenis'];
                $keperluan = $_POST['keperluan'];
                $prefix = 'SRT';
                $uniqid = uniqid($prefix);
                if(isset($_FILES["files"]) && !empty($_FILES["files"]["name"])){
                    foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
                        $file_name = $key.$_FILES['files']['name'][$key];
                        $file_size =$_FILES['files']['size'][$key];
                        $file_tmp =$_FILES['files']['tmp_name'][$key];
                        $file_type=$_FILES['files']['type'][$key];
                        
                        $original_filename = $_FILES['files']['name'][$key];
                        $ext = strtolower(pathinfo($_FILES["files"]["name"][$key], PATHINFO_EXTENSION));
                        // check extension and upload
                        if(in_array( $ext, array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'pdf'))) {
                            $filename_without_ext = basename($original_filename, '.'.$ext);
                            $new_filename = uniqid() .  '_' . $nik . '.' . $ext;
                            move_uploaded_file($file_tmp,'berkas/'.$new_filename);
                            // Masuk Lampiran
                            $sql = "INSERT INTO lampiran(nik, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran) 
                            VALUES('$nik', '$new_filename', 'Laporan Masyarakat', '$tanggal', 'Pending', '-')";
                            $query = mysqli_query($koneksi, $sql);
                            $sql_pelaporan = "INSERT INTO suratketerangan(no_surat, nik, id_rt, id_rw, jenis, keperluan, tanggal_pengajuan, keterangan, status)
                            VALUES ('$uniqid', '$nik', '$rt', '$rw', '$jenis', '$keperluan', '$tanggal', '$keterangan', 'Pending')";
                            $query_pelaporan = mysqli_query($koneksi, $sql_pelaporan);
                            header("Location: index.php?pesan=Berhasil");
                        }
                        else{
                            header("Location: index.php?pesan=Gagal");
                        }
                    }
                }else{
                    
                }
                
            }                  
            break;
        case 'verifikasi_surat' :
            $id = $data['id'];
            $new = "Terverifikasi";
            $sql = "UPDATE suratketerangan SET status='$new', alasan='' WHERE no_surat='$id'";
            $query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
            if($query){
                header("Location: ../views/super/index.php?pesan=Sukses !");
                exit;
            }
            break;
        case 'tolak_surat':
            $id = $data['id'];
            $new = "Ditolak";
            $catatan = $data['alasan'];
            $sql = "UPDATE suratketerangan SET status='$new', alasan='$catatan' WHERE no_surat='$id'";
            $query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
            if($query){
                header("Location: ../views/super/index.php?pesan=Sukses !");
                exit;
            }
            break;
        case 'hapus_surat' :
            $id = $data['id'];
            $sql = "DELETE FROM suratketerangan WHERE no_surat='$id'";
            $query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
            if($query){
                header("Location: ../views/super/index.php?pesan=Sukses");
                exit;
            }    
            break;
        default:
        echo 'gk masuk';
            break;
    }
?>