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
            $nama = $koneksi->prepare("SELECT * FROM penduduk WHERE nik=?");
            $nama->bind_param('s', $nik);
            $nama->execute();
            $nama2 = $nama->get_result();
            $data_nama = $nama2->fetch_assoc();
            $nama_penduduk = $data_nama['nama'];
            $rt_penduduk = $data_nama['id_rt'];
            $rw_penduduk = $data_nama['id_rw'];
            // Eksekusi
            $sql = $koneksi->prepare("INSERT INTO tagihan(id_tagihan, nik, id_rt, id_rw, jenis_tagihan, total_tagihan, jatuh_tempo, status_pembayaran, rekening, bukti_pembayaran) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $unpaid = 'Unpaid';
            $strip = '-';
            $sql->bind_param('ssssssssss', $uniqid, $nik, $rt_penduduk, $rw_penduduk, $perihal, $nominal, $tanggal, $unpaid, $rekening, $strip);
            $query = $sql->execute();
            if($query == true){
                header("Location: ../views/iuran/index?pesan=sukses");
                exit;
            }else{
                header("Location: ../views/iuran/index?pesan=gagal");
                exit;
            }
            break;
        case 'verifikasi_iuran' :
            $id = $data['id'];
            $id_lampiran = $data['lampiran'];
            $paid = 'Paid';
            $status_lampiran = 'Telah Diperiksa';
            // Tabel tagihan
            $sql = $koneksi->prepare("UPDATE tagihan SET status_pembayaran=? WHERE id_tagihan=?");
            $sql->bind_param('ss', $paid, $id);
            $sql_status = $sql->execute();
            // Tabel lampiran
            if($id_lampiran == 'Semua') {
                $sql_lampiran = $koneksi->prepare("UPDATE lampiran SET status_lampiran=?, ket_lampiran=? WHERE kode=?");
                $sql_lampiran->bind_param('sss', $status_lampiran, $paid, $id);
                $sql_lampiran_status = $sql_lampiran->execute();
            }else{
                $sql_lampiran = $koneksi->prepare("UPDATE lampiran SET status_lampiran=?, ket_lampiran=? WHERE kode=? AND lampiran=?");
                $sql_lampiran->bind_param('ssss', $status_lampiran, $paid, $id, $id_lampiran);
                $sql_lampiran_status = $sql_lampiran->execute();
            }

            if($sql_status == true && $sql_lampiran_status == true){
                header("Location: ../views/iuran/index?pesan=sukses");
                exit;
            }else{
                header("Location: ../views/iuran/index?pesan=gagal");
                exit;
            }
            break;
        case 'tolak_iuran':
            $id = $data['id'];
            $id_lampiran = $data['lampiran'];
            $catatan = $data['alasan'];
            $unpaid = 'Unpaid';
            // Tabel tagihan
            $sql = $koneksi->prepare("UPDATE tagihan SET status_pembayaran=? WHERE id_tagihan=?");
            $sql->bind_param('ss', $unpaid, $id);
            $sql_status = $sql->execute();
            // Tabel lampiran
            $status_lampiran = 'Telah Diperiksa';
            // Tabel lampiran
            if($id_lampiran == 'Semua') {
                $sql_lampiran = $koneksi->prepare("UPDATE lampiran SET status_lampiran=?, ket_lampiran=? WHERE kode=?");
                $sql_lampiran->bind_param('sss', $status_lampiran, $catatan, $id);
                $sql_lampiran_status = $sql_lampiran->execute();
            }else{
                $sql_lampiran = $koneksi->prepare("UPDATE lampiran SET status_lampiran=?, ket_lampiran=? WHERE kode=? AND lampiran=?");
                $sql_lampiran->bind_param('ssss', $status_lampiran, $catatan, $id, $id_lampiran);
                $sql_lampiran_status = $sql_lampiran->execute();
            }

            if($sql_status == true && $sql_lampiran_status == true){
                header("Location: ../views/iuran/index?pesan=sukses");
                exit;
            }else{
                header("Location: ../views/iuran/index?pesan=gagal");
                exit;
            }
            break;
        case 'bayar_iuran':
            if(isset($_POST['submit'])){
                $id = $_POST['id'];
                $nik = $_SESSION['nik'];
                $tanggal = date("Y-m-d");
                $prefix = 'TGHN';
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
                            move_uploaded_file($file_tmp,'../berkas/iuran/'.$new_filename);
                            // Masuk Lampiran
                            $sql = $koneksi->prepare("INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran) 
                            VALUES(?, ?, ?, ?, ?, ?, ?)");
                            $jenis_lampiran = 'Pembayaran Tagihan';
                            $tipe_status = 'Pending';
                            $strip = '-';
                            $sql->bind_param('sssssss', $nik, $id, $new_filename, $jenis_lampiran, $tanggal, $tipe_status, $strip);
                            $sql_lampiran = $sql->execute();
                            $sql2 = $koneksi->prepare("UPDATE tagihan SET bukti_pembayaran = ? WHERE id_tagihan = ?");
                            $sql2->bind_param('ss', $new_filename, $id);
                            $sql_tagihan = $sql2->execute();
                            header("Location: ../views/iuran/index?pesan=sukses");
                        }
                        else{
                            header("Location: ../views/iuran/index?pesan=ekstensi");
                        }
                    }
                }else{
                    header("Location: ../views/iuran/index?pesan=nofile");
                }
            }else{
                header("Location: ../views/iuran/index?pesan=error");
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
                if(isset($_POST['kategori'])){
                    $kategori = $_POST['kategori'];
                }else if(!isset($_POST['kategori'])){
                    $kategori = $_POST['kategori_lainnya'];
                }
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
                            move_uploaded_file($file_tmp,'../berkas/laporan/'.$new_filename);
                            // Masuk Lampiran
                            $sql = $koneksi->prepare("INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran) 
                            VALUES(?, ?, ?, ?, ?, ?, ?)");
                            $jenis_lampiran = 'Laporan Masyarakat';
                            $tipe_status = 'Pending';
                            $strip = '-';
                            $sql->bind_param('sssssss', $nik, $uniqid, $new_filename, $jenis_lampiran, $tanggal, $tipe_status, $strip);
                            $sql_lampiran = $sql->execute();
                            $sql2 = $koneksi->prepare("INSERT INTO pelaporan(id_pelaporan, nik, id_rt, id_rw, kategori, keterangan, tanggal_pelaporan, status)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                            $sql2->bind_param('ssssssss', $uniqid, $nik, $rt, $rw, $kategori, $keterangan, $tanggal, $tipe_status);
                            $sql_laporan = $sql2->execute();
                            header("Location: ../views/laporan/index?pesan=sukses");
                        }
                        else{
                            header("Location: ../views/laporan/index?pesan=ekstensi");
                        }
                    }
                }else{
                    header("Location: ../views/laporan/index?pesan=nofile");
                }
            }else{
                header("Location: ../views/laporan/index?pesan=gagal");
            }                  
            break;
        case 'verifikasi_laporan':
            $id = $data['id'];
            $id_lampiran = $data['lampiran'];
            $catatan = $data['alasan'];
            $verified = 'Terverifikasi';
            $status_lampiran = 'Telah Diperiksa';
            // Tabel tagihan
            $sql = $koneksi->prepare("UPDATE pelaporan SET status=?, alasan=? WHERE id_pelaporan=?");
            $sql->bind_param('sss', $verified, $catatan, $id);
            $sql_status = $sql->execute();
            // Tabel lampiran
            if($id_lampiran == 'Semua') {
                $sql_lampiran = $koneksi->prepare("UPDATE lampiran SET status_lampiran=?, ket_lampiran=? WHERE kode=?");
                $sql_lampiran->bind_param('sss', $status_lampiran, $catatan, $id);
                $sql_lampiran_status = $sql_lampiran->execute();
            }else{
                $sql_lampiran = $koneksi->prepare("UPDATE lampiran SET status_lampiran=?, ket_lampiran=? WHERE kode=? AND lampiran=?");
                $sql_lampiran->bind_param('ssss', $status_lampiran, $catatan, $id, $id_lampiran);
                $sql_lampiran_status = $sql_lampiran->execute();
            }

            if($sql_status == true && $sql_lampiran_status == true){
                header("Location: ../views/laporan/index?pesan=sukses");
                exit;
            }else{
                header("Location: ../views/laporan/index?pesan=gagal");
                exit;
            }
            break;
        case 'tolak_laporan':
            $id = $data['id'];
            $id_lampiran = $data['lampiran'];
            $catatan = $data['alasan'];
            $verified = 'Pending';
            $status_lampiran = 'Telah Diperiksa';
            // Tabel tagihan
            $sql = $koneksi->prepare("UPDATE pelaporan SET status=?, alasan=? WHERE id_pelaporan=?");
            $sql->bind_param('sss', $verified, $catatan, $id);
            $sql_status = $sql->execute();
            // Tabel lampiran
            if($id_lampiran == 'Semua') {
                $sql_lampiran = $koneksi->prepare("UPDATE lampiran SET status_lampiran=?, ket_lampiran=? WHERE kode=?");
                $sql_lampiran->bind_param('sss', $status_lampiran, $catatan, $id);
                $sql_lampiran_status = $sql_lampiran->execute();
            }else{
                $sql_lampiran = $koneksi->prepare("UPDATE lampiran SET status_lampiran=?, ket_lampiran=? WHERE kode=? AND lampiran=?");
                $sql_lampiran->bind_param('ssss', $status_lampiran, $catatan, $id, $id_lampiran);
                $sql_lampiran_status = $sql_lampiran->execute();
            }

            if($sql_status == true && $sql_lampiran_status == true){
                header("Location: ../views/laporan/index?pesan=sukses");
                exit;
            }else{
                header("Location: ../views/laporan/index?pesan=gagal");
                exit;
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
                            $new_filename = $uniqid .  '_' . $nik . '.' . $ext;
                            move_uploaded_file($file_tmp,'../berkas/pengumuman/'.$new_filename);
                            // Masuk Lampiran
                            $sql = $koneksi->prepare("INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran) 
                            VALUES(?, ?, ?, ?, ?, ?, ?)");
                            $jenis_lampiran = 'Pengumuman Warga';
                            $strip = '-';
                            $sql->bind_param('sssssss', $nik, $uniqid, $new_filename, $jenis_lampiran, $tanggal, $strip, $strip);
                            $sql_lampiran = $sql->execute();
                            $sql_pengumuman = $koneksi->prepare("INSERT INTO pengumuman(id, pengumuman, isi, tanggal, id_rt, id_rw, pengirim)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
                            $sql_pengumuman->bind_param('sssssss', $uniqid, $perihal, $keterangan, $tanggal, $rt, $rw, $nama);
                            $sql_pengumuman_status = $sql_pengumuman->execute();
                            header("Location: ../views/pengumuman/index?pesan=sukses");
                        }
                        else{
                            header("Location: ../views/pengumuman/index?pesan=ekstensi");
                        }
                    }
                }else{
                    header("Location: ../views/pengumuman/index?pesan=file");
                }
            }else{
                header("Location: ../views/pengumuman/index?pesan=gagal");
            }                  
            break;
        // Super
        case 'update' :
            // Kode Wilayah
            $provinsi = $data['provinsi'];
            $kabkota = $data['kabkota'];
            $kecamatan = $data['kecamatan'];
            $kelurahan = $data['desa_kelurahan'];
            // Nama Provinsi
            $nama_provinsi = $koneksi->prepare("SELECT * FROM msprovinsi WHERE id_provinsi=?");
            $nama_provinsi->bind_param('s', $provinsi);
            $nama_provinsi->execute();
            $nama_provinsi2 = $nama_provinsi->get_result();
            $dataProvinsi = $nama_provinsi2->fetch_assoc();
            $currentProv = $dataProvinsi['nama_provinsi'];
            // Nama Kabkota
            $nama_kabkota = $koneksi->prepare("SELECT * FROM mskabkota WHERE id_kabkota=?");
            $nama_kabkota->bind_param('s', $kabkota);
            $nama_kabkota->execute();
            $nama_kabkota2 = $nama_kabkota->get_result();
            $dataKabkota = $nama_kabkota2->fetch_assoc();
            $currentKota = $dataKabkota['nama_kabkota'];
            // Nama Kecamatan
            $nama_kecamatan = $koneksi->prepare("SELECT * FROM mskecamatan WHERE id_kecamatan=?");
            $nama_kecamatan->bind_param('s', $kecamatan);
            $nama_kecamatan->execute();
            $nama_kecamatan2 = $nama_kecamatan->get_result();
            $dataKecamatan = $nama_kecamatan2->fetch_assoc();
            $currentKec = $dataKecamatan['nama_kecamatan'];
            // Nama Kelurahan
            $nama_kelurahan = $koneksi->prepare("SELECT * FROM mskelurahan WHERE id_kelurahan=?");
            $nama_kelurahan->bind_param('s', $kelurahan);
            $nama_kelurahan->execute();
            $nama_kelurahan2 = $nama_kelurahan->get_result();
            $dataKelurahan = $nama_kelurahan2->fetch_assoc();
            $currentKel = $dataKelurahan['nama_kelurahan'];
            // Set
            $sql = $koneksi->prepare("UPDATE mssettings SET 
            id_provinsi=?, 
            nama_provinsi=?, 
            id_kabkota=?,
            nama_kabkota=?,
            id_kecamatan=?,
            nama_kecamatan=?,
            id_kelurahan=?,
            nama_kelurahan=?
            WHERE identifier=?");
            $satu = '1';
            $sql->bind_param('sssssssss', $provinsi, $currentProv, $kabkota, $currentKota, $kecamatan, $currentKec, $kelurahan, $currentKel, $satu);
            $query = $sql->execute();
            if($query == true){
                header("Location: ../views/super/pengaturan.php?pesan=sukses");
                exit;
            }else{
                header("Location: ../views/super/pengaturan.php?pesan=gagal");
                exit;
            }
            break;
        case 'tambah_rt':
            $rt = $data['rt'];
            $rw = $data['rw'];
            $nik = $data['nik'];
            // Cek Nama Pejabat
            $nama = $koneksi->prepare("SELECT * FROM penduduk WHERE nik=?");
            $nama->bind_param('s', $nik);
            $nama->execute();
            $nama2 = $nama->get_result();
            $data_nama = $nama2->fetch_assoc();
            $nama_pejabat = $data_nama['nama'];
            // Eksekusi
            $sql = $koneksi->prepare("INSERT INTO msrt (id_rt, id_rw, nik_ketuart, nama_rt) VALUES (?, ?, ?, ?)");
            $sql->bind_param('ssss', $rt, $rw, $nik, $nama_pejabat);
            $query = $sql->execute();
            if($query == true){
                header("Location: ../views/super/list_rt?pesan=sukses");
                exit;
            }else{
                header("Location: ../views/super/list_rt?pesan=gagal");
                exit;
            }
            break;
        case 'update_rt':
            $rt = $data['id_rt'];
            $nik = $data['nik'];
            // Cek Nama Pejabat
            $nama = $koneksi->prepare("SELECT * FROM penduduk WHERE nik=?");
            $nama->bind_param('s', $nik);
            $nama->execute();
            $nama2 = $nama->get_result();
            $data_nama = $nama2->fetch_assoc(); 
            $nama_pejabat = $data_nama['nama'];
            // Eksekusi
            $sql = $koneksi->prepare("UPDATE msrt SET nik_ketuart=?, nama_rt=? WHERE id_rt=?");
            $sql->bind_param('sss', $nik, $nama_pejabat, $rt);
            $query = $sql->execute();
            if($query == true){
                header("Location: ../views/super/list_rt?pesan=sukses");
                exit;
            }else{
                header("Location: ../views/super/list_rt?pesan=gagal");
                exit;
            }
            break;
        case 'tambah_rw':
            $rw = $data['rw'];
            $kelurahan = $data['kelurahan'];
            $nik = $data['nik'];
            // Cek Nama Pejabat
            $nama = $koneksi->prepare("SELECT * FROM penduduk WHERE nik=?");
            $nama->bind_param('s', $nik);
            $nama->execute();
            $nama2 = $nama->get_result();
            $data_nama = $nama2->fetch_assoc();
            $nama_pejabat = $data_nama['nama'];
            // Eksekusi
            $sql = $koneksi->prepare("INSERT INTO msrw(id_rw, id_kelurahan, nik_ketuarw, nama_rw) VALUES (?, ?, ?, ?)");
            $sql->bind_param('ssss', $rw, $kelurahan, $nik, $nama_pejabat);
            $query = $sql->execute();
            if($query == true){
                header("Location: ../views/super/list_rw?pesan=sukses");
                exit;
            }else{
                header("Location: ../views/super/list_rw?pesan=gagal");
                exit;
            }
            break;
        case 'update_rw':
            $rw = $data['id_rw'];
            $nik = $data['nik'];
            // Cek Nama Pejabat
            $nama = $koneksi->prepare("SELECT * FROM penduduk WHERE nik=?");
            $nama->bind_param('s', $nik);
            $nama->execute();
            $nama2 = $nama->get_result();
            $data_nama = $nama2->fetch_assoc(); 
            $nama_pejabat = $data_nama['nama'];
            // Eksekusi
            $sql = $koneksi->prepare("UPDATE msrw SET nik_ketuarw=?, nama_rw=? WHERE id_rw=?");
            $sql->bind_param('sss', $nik, $nama_pejabat, $rw);
            $query = $sql->execute();
            if($query == true){
                header("Location: ../views/super/list_rw?pesan=sukses");
                exit;
            }else{
                header("Location: ../views/super/list_rw?pesan=gagal");
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
                $tujuan = $_POST['tujuan'];
                if(isset($_POST['jenis'])){
                    $jenis = $_POST['jenis'];
                }else if(!isset($_POST['jenis'])){
                    $jenis = $_POST['jenis_lainnya'];
                }
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
                            move_uploaded_file($file_tmp,'../berkas/surat/'.$new_filename);
                            // Masuk Lampiran
                            $sql = $koneksi->prepare("INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran) 
                            VALUES(?, ?, ?, ?, ?, ?, ?)");
                            $jenis_lampiran = 'Pengajuan Surat';
                            $tipe_status = 'Pending';
                            $strip = '-';
                            $sql->bind_param('sssssss', $nik, $uniqid, $new_filename, $jenis_lampiran, $tanggal, $tipe_status, $strip);
                            $sql_lampiran = $sql->execute();
                            $sql_surat = $koneksi->prepare("INSERT INTO suratketerangan(no_surat, nik, id_rt, id_rw, jenis, keperluan, tanggal_pengajuan, tujuan, keterangan, status)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                            $sql_surat->bind_param('ssssssssss', $uniqid, $nik, $rt, $rw, $jenis, $keperluan, $tanggal, $tujuan, $keterangan, $tipe_status);
                            $sql_surat->execute();
                            header("Location: ../views/surat/index?sukses=sukses");
                        }
                        else{
                            header("Location: ../views/surat/index?pesan=ekstensi");
                        }
                    }
                }else{
                    header("Location: ../views/surat/index?pesan=file");
                }
                
            }else{
                header("Location: ../views/surat/index?pesan=gagal");
            }                  
            break;
        case 'verifikasi_surat' :
            $id = $data['id'];
            $id_lampiran = $data['lampiran'];
            $new = "Terverifikasi";
            $empty = ' ';
            $status_lampiran = 'Telah Diperiksa';
            // Tabel pelaporan
            $sql = $koneksi->prepare("UPDATE suratketerangan SET status=?, alasan=? WHERE no_surat=?");
            $sql->bind_param('sss', $new, $catatan, $id);
            $sql_status = $sql->execute();
            // Tabel lampiran
            if($id_lampiran == 'Semua') {
                $sql_lampiran = $koneksi->prepare("UPDATE lampiran SET status_lampiran=?, ket_lampiran=? WHERE kode=?");
                $sql_lampiran->bind_param('sss', $status_lampiran, $catatan, $id);
                $sql_lampiran_status = $sql_lampiran->execute();
            }else{
                $sql_lampiran = $koneksi->prepare("UPDATE lampiran SET status_lampiran=?, ket_lampiran=? WHERE kode=? AND lampiran=?");
                $sql_lampiran->bind_param('ssss', $status_lampiran, $catatan, $id, $id_lampiran);
                $sql_lampiran_status = $sql_lampiran->execute();
            }
            if($sql_status == true && $sql_lampiran_status == true){
                header("Location: ../views/surat/index?pesan=sukses");
                exit;
            }else{
                header("Location: ../views/surat/index?pesan=gagal");
                exit;
            }
            break;
        case 'tolak_surat':
            $id = $data['id'];
            $id_lampiran = $data['lampiran'];
            $new = "Ditolak";
            $catatan = $data['alasan'];
            $status_lampiran = 'Telah Diperiksa';
            // Tabel suratketerangan
            $sql = $koneksi->prepare("UPDATE suratketerangan SET status=?, alasan=? WHERE no_surat=?");
            $sql->bind_param('sss', $new, $catatan, $id);
            $query = $sql->execute();
            // Tabel lampiran
            if($id_lampiran == 'Semua') {
                $sql_lampiran = $koneksi->prepare("UPDATE lampiran SET status_lampiran=?, ket_lampiran=? WHERE kode=?");
                $sql_lampiran->bind_param('sss', $status_lampiran, $catatan, $id);
                $sql_lampiran_status = $sql_lampiran->execute();
            }else{
                $sql_lampiran = $koneksi->prepare("UPDATE lampiran SET status_lampiran=?, ket_lampiran=? WHERE kode=? AND lampiran=?");
                $sql_lampiran->bind_param('ssss', $status_lampiran, $catatan, $id, $id_lampiran);
                $sql_lampiran_status = $sql_lampiran->execute();
            }
            if($query == true && $sql_lampiran_status == true){
                header("Location: ../views/surat/index?pesan=sukses");
                exit;
            }else{
                header("Location: ../views/surat/index?pesan=gagal");
                exit;
            }
            break;
        case 'hapus_surat' :
            $id = $data['id'];
            $sql = $koneksi->prepare("DELETE FROM suratketerangan WHERE no_surat=?");
            $sql->bind_param('s', $id);
            $query = $sql->execute();
            if($query == true){
                header("Location: ../views/surat/index?pesan=sukses");
                exit;
            }else{
                header("Location: ../views/surat/index?pesan=gagal");
                exit;
            }
            break;
        // PDF
        case 'create_pdf_iuran':
            require_once 'fpdf.php';
            $pdf = new FPDF('P','mm',array(100,100));
            $pdf->AddPage();

            $id = $_GET['id'];
            $sql = $koneksi->prepare("SELECT * FROM tagihan WHERE id_tagihan=?");
            $sql->bind_param('s', $id);
            $sql->execute();
            $sql2 = $sql->get_result();
            $identifikasi = $sql2->fetch_assoc();
            // Cek Nama
            $cek_nik = $identifikasi['nik'];
            $nama = $koneksi->prepare("SELECT nama, alamat FROM penduduk WHERE nik=?");
            $nama->bind_param('s', $cek_nik);
            $nama->execute();
            $nama2 = $nama->get_result();
            $identifikasi_nama = $nama2->fetch_assoc();
            $nomor = $identifikasi['id_tagihan'];
            $nama = $identifikasi_nama['nama'];
            $alamat = $identifikasi_nama['alamat'];
            $total = $identifikasi['total_tagihan'];
            $jenis = $identifikasi['jenis_tagihan'];
            $status = $identifikasi['status_pembayaran'];
            $rekening = $identifikasi['rekening'];
            $pdf->Image('logo_rw5.png',7,6,50);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell( 0, 3, 'Surat Pembayaran', 0, 0, 'C');
            $pdf->Ln(7);
            $pdf->Cell( 0, 3, 'Nomor : '. $nomor, 0, 0, 'C');
            $pdf->Ln(7);
            $pdf->Cell( 0, 3, 'Nama : '. $nama, 0, 0, 'J');
            $pdf->Ln(3);
            $pdf->Cell( 0, 3, 'Alamat : '. $alamat, 0, 0, 'J');
            $pdf->Ln(3);
            $pdf->Cell( 0, 3, 'Sejumlah : Rp.'. $total, 0, 0, 'J');
            $pdf->Ln(7);
            $pdf->Cell( 0, 3, 'Pembayaran ini diperuntukkan sebagai', 0, 0, 'C');
            $pdf->Ln(3);
            $pdf->Cell( 0, 3, 'Tagihan '.$jenis, 0, 0, 'C');
            $pdf->Ln(7);
            $pdf->Cell( 0, 3, 'Status Pembayaran', 0, 0, 'C');
            if($status == 'Unpaid'){
                $tanggal = $identifikasi['jatuh_tempo'];
                $month = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
                $tanggal_hari = (int)date('d', strtotime($identifikasi['jatuh_tempo']));
                $bulan_hari = $month[((int)date('m', strtotime($identifikasi['jatuh_tempo']))) - 1];
                $tahun_hari = (int)date('Y', strtotime($identifikasi['jatuh_tempo']));
                $pdf->Ln(3);
                $pdf->Cell( 0, 3, 'Belum Terbayar', 0, 0, 'C');
                $pdf->Ln(5);
                $pdf->Cell( 0, 3, 'Segera Lakukan Pembayaran Ke Rekening BCA-'.$rekening, 0, 0, 'C');
                $pdf->Ln(5);
                $pdf->Cell( 0, 3, 'Sebelum Tanggal '.$tanggal_hari.' '.$bulan_hari.' '.$tahun_hari, 0, 0, 'C');
                $pdf->Ln(7);
                $pdf->Cell( 0, 3, 'Bendahara Desa', 0, 0, 'C');
                $pdf->Ln(9);
                $pdf->Cell( 0, 3, 'Sujatmiko', 0, 0, 'C');
                // File
                $date = date('Y-m-d');
                $filename=$id.'_'.$cek_nik.'.pdf';
                $pdf->Output('F', '../berkas/iuran/' . $filename, true);
                $pdf->Output();
                // Masuk daftar lampiran
                $lampiran = $koneksi->prepare("INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran)
                VALUES (?, ?, ?, ?, ?, ?, ?)");
                $jenis_lampiran = 'Pembayaran Tagihan';
                $strip = '-';
                $lampiran->bind_param('sssssss', $cek_nik, $id, $filename, $jenis_lampiran, $date, $status, $strip);
                $lampiran->execute();
                
            }else if($status == 'Paid'){
                $tanggal = $identifikasi['tanggal_pembayaran'];
                $month = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
                $tanggal_hari = (int)date('d', strtotime($identifikasi['tanggal_pembayaran']));
                $bulan_hari = $month[((int)date('m', strtotime($identifikasi['tanggal_pembayaran']))) - 1];
                $tahun_hari = (int)date('Y', strtotime($identifikasi['tanggal_pembayaran']));
                $pdf->Ln(3);
                $pdf->Cell( 0, 3, 'Lunas', 0, 0, 'C');
                $pdf->Ln(5);
                $pdf->Cell( 0, 3, 'Dibayar tanggal '.$tanggal_hari.' '.$bulan_hari.' '.$tahun_hari, 0, 0, 'C');
                $pdf->Ln(11);
                $pdf->Cell( 0, 3, 'Bendahara Desa', 0, 0, 'C');
                $pdf->Ln(10);
                $pdf->Cell( 0, 3, 'Sujatmiko', 0, 0, 'C');
                // File
                $date = date('Y-m-d');
                $filename=$id.'_'.$cek_nik.'.pdf';
                $pdf->Output('F', '../berkas/iuran/' . $filename, true);
                $pdf->Output();
                // Masuk daftar lampiran
                $lampiran = $koneksi->prepare("INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran)
                VALUES (?, ?, ?, ?, ?, ?, ?)");
                $jenis_lampiran = 'Pembayaran Tagihan';
                $strip = '-';
                $lampiran->bind_param('sssssss', $cek_nik, $id, $filename, $jenis_lampiran, $date, $status, $strip);
                $lampiran->execute();
            }
            break;
        case 'create_pdf_surat':
            include 'roman.php';
            require_once 'fpdf.php';
            $pdf = new FPDF('P','mm',array(210,297));
            $pdf->AddPage();

            $id = $_GET['id'];
            $sql = $koneksi->prepare("SELECT * FROM suratketerangan WHERE no_surat=?");
            $sql->bind_param('s', $id);
            $sql->execute();
            $sql2 = $sql->get_result();
            $identifikasi = $sql2->fetch_assoc();
            // Cek Nama
            $cek_nik = $identifikasi['nik'];
            $nama = $koneksi->prepare("SELECT nama, alamat, pekerjaan, jenis_kelamin, tempat_lahir, 
            tanggal_lahir, status_perkawinan, kewarganegaraan, no_kk, agama 
            FROM penduduk WHERE nik=?");
            $nama->bind_param('s', $cek_nik);
            $nama->execute();
            $nama2 = $nama->get_result();
            $identifikasi_nama = $nama2->fetch_assoc();

            // Ketua RT dan rw
            $nama_ketua = $koneksi->prepare("SELECT nama_rt, nama_rw FROM msrt INNER JOIN msrw WHERE msrt.id_rt = ? AND msrw.id_rw = ?");
            $nama_ketua->bind_param('ss', $identifikasi['id_rt'], $identifikasi['id_rw']);
            $nama_ketua->execute();
            $nama_ketua2 = $nama_ketua->get_result();
            $fetch_ketua = $nama_ketua2->fetch_assoc();

            // Mssetting
            $nama_daerah = $koneksi->prepare("SELECT * FROM mssettings");
            $nama_daerah->execute();
            $nama_daerah2 = $nama_daerah->get_result();
            $fetch_daerah = $nama_daerah2->fetch_assoc();
            $daerah = strtoupper($fetch_daerah['nama_kelurahan']);
            $id_provinsi_no = $fetch_daerah['id_provinsi'];
            $id_kabkota_no = $fetch_daerah['id_kabkota'];
            $id_kecamatan_no = $fetch_daerah['id_kecamatan'];
            $id_kelurahan_no = $fetch_daerah['id_kelurahan'];

            // Lokasi
            $nomor = numberToRomanRepresentation($identifikasi['id_rt']);
            $nomor_rw = numberToRomanRepresentation($identifikasi['id_rw']);
            $nama = $identifikasi_nama['nama'];
            $alamat = $identifikasi_nama['alamat'];
            $pekerjaan = $identifikasi_nama['pekerjaan'];
            $jenis_kelamin = $identifikasi_nama['jenis_kelamin'];
            $tempat_lahir = $identifikasi_nama['tempat_lahir'];
            $tanggal_lahir = $identifikasi_nama['tanggal_lahir'];
            $status_perkawinan = $identifikasi_nama['status_perkawinan'];
            $agama = $identifikasi_nama['agama'];
            $kewarganegaraan = $identifikasi_nama['kewarganegaraan'];
            $no_kk = $identifikasi_nama['no_kk'];
            
            // Ubah tanggal lahir
            $month = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
            $tanggal_hari = (int)date('d', strtotime($tanggal_lahir));
            $bulan_hari = $month[((int)date('m', strtotime($tanggal_lahir))) - 1];
            $tahun_hari = (int)date('Y', strtotime($tanggal_lahir));

            // Surat
            $total = $identifikasi['jenis'];
            $jenis = $identifikasi['keperluan'];
            $tujuan = $identifikasi['tujuan'];
            $status = $identifikasi['tanggal_pengajuan'];
            $rekening = $identifikasi['keterangan'];

            // Ubah tanggal surat
            $month = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
            $tanggal_status = (int)date('d', strtotime($status));
            $bulan_status = $month[((int)date('m', strtotime($status))) - 1];
            $tahun_status = (int)date('Y', strtotime($status));

            $bagian_akhir_keldesa = explode(' ', $daerah);
            $keldesa_akhir = array_pop($bagian_akhir_keldesa);

            $pdf->Image('logo_rw5.png',5,6,50);
            $pdf->SetFont('times','B',15);
            $pdf->Ln(7);
            $pdf->Cell( 0, 3, 'SURAT PENGANTAR / KETERANGAN', 0, 0, 'C');
            $pdf->Ln(9);
            $pdf->Cell( 0, 3, 'RT. : '. $nomor.'                             '.'RW. : '. $nomor_rw, 0, 0, 'C');
            $pdf->Ln(9);
            $pdf->Cell( 0, 3, 'KELURAHAN : '.$keldesa_akhir, 0, 0, 'C');
            $pdf->Ln(9);
            $pdf->Cell( 0, 3, 'NO. '.$id_provinsi_no.'/'.$id_kabkota_no.'/'.$id_kecamatan_no.'/'.$id_kelurahan_no.'/'.$id, 0, 0, 'C');
            $pdf->Ln(9);
            $pdf->Image('surabaya-logo.png',165,6,37);
            $pdf->Ln(7);
            $pdf->SetFont('times','B',12);
            // Removes bold
            $pdf->SetFont('');
            $pdf->Ln(7);
            $pdf->Cell( 0, 3, 'Yang bertanda tangan dibawah ini, menerangkan : ', 0, 0, 'J');
            $pdf->Ln(7);
            $pdf->cell(10,0.5);
            $pdf->Cell( 0, 3, 'Nama Lengkap               : '.$nama, 0, 0, 'J');
            $pdf->Ln(7);
            $pdf->cell(10,0.5);
            $pdf->Cell( 0, 3, 'Alamat                            : '.$alamat, 0, 0, 'J');
            $pdf->Ln(7);
            $pdf->cell(10,0.5);
            $pdf->Cell( 0, 3, 'Pekerjaan                        : '.$pekerjaan, 0, 0, 'J');
            $pdf->Ln(7);
            $pdf->cell(10,0.5);
            $pdf->Cell( 0, 3, 'Jenis Kelamin                 : '.$jenis_kelamin, 0, 0, 'J');
            $pdf->Ln(7);
            $pdf->cell(10,0.5);
            $pdf->Cell( 0, 3, 'Tempat / Tanggal Lahir  : '.$tempat_lahir.' / '.$tanggal_hari.' '.$bulan_hari.' '.$tahun_hari, 0, 0, 'J');
            $pdf->Ln(7);
            $pdf->cell(10,0.5);
            $pdf->Cell( 0, 3, 'Kawin / Tidak Kawin     : '.$status_perkawinan, 0, 0, 'J');
            $pdf->Ln(7);
            $pdf->cell(10,0.5);
            $pdf->Cell( 0, 3, 'Agama                            : '.$agama, 0, 0, 'J');
            $pdf->Ln(7);
            $pdf->cell(10,0.5);
            $pdf->Cell( 0, 3, 'Kewarganegaraan           : '.$kewarganegaraan, 0, 0, 'J');
            $pdf->Ln(7);
            $pdf->cell(10,0.5);
            $pdf->Cell( 0, 3, 'Nomor KK / KTP           : '.$cek_nik.' / '.$no_kk, 0, 0, 'J');
            $pdf->Ln(7);
            $pdf->cell(10,0.5);
            $pdf->Cell( 0, 3, 'Tujuan                            : '.$tujuan, 0, 0, 'J');
            $pdf->Ln(7);
            $pdf->cell(10,0.5);
            $pdf->Cell( 0, 3, 'Keperluan                       : '.$jenis, 0, 0, 'J');
            $pdf->Ln(14);
            $pdf->Cell( 0, 3, 'Keterangan lain - lain              : '.$rekening, 0, 0, 'J');
            $pdf->Ln(7);
            $pdf->Cell( 0, 3, 'Demikian agar mendapat bantuan seperlunya.', 0, 0, 'J');
            $pdf->Ln(10);
            $pdf->cell(10,0.5);
            $nama_kabkota = $fetch_daerah['nama_kabkota'];
            $bagian_akhir = explode(' ', $nama_kabkota);
            $kabkota_akhir = array_pop($bagian_akhir);
            $pdf->Cell( 0, 3, 'Tanda tangan.'.'                                                                                             '.$kabkota_akhir.', '.$tanggal_status.' '.$bulan_status.' '.$tahun_status.'', 0, 0, 'J');
            $pdf->Ln(7);
            $pdf->cell(7,0.5);
            $pdf->Cell( 0, 3, 'yang bersangkutan                                                                                                            Ketua RT', 0, 0, 'J');
            $pdf->Ln(20);
            $pdf->Cell( 0, 3, '('.$nama.')                                                                                      ('.$fetch_ketua['nama_rt'].')', 0, 0, 'J');
            $pdf->Ln(10);
            $pdf->Cell( 0, 3, 'No. : ...... / 402 / 96.06 / 03.V / 20 .....', 0, 0, 'J');
            $pdf->Ln(15);
            $pdf->Cell( 0, 3, 'Mengetahui', 0, 0, 'C');
            $pdf->Ln(7);
            $pdf->Cell( 0, 3, 'Ketua RW. '.$nomor_rw, 0, 0, 'C');
            $pdf->Ln(20);
            $pdf->Cell( 0, 3, '('.$fetch_ketua['nama_rw'].')', 0, 0, 'C');
            // File
            $date = date('Y-m-d');
            $filename=$id.'_'.$cek_nik.'.pdf';
            $pdf->Output('F', '../berkas/surat/' . $filename, true);
            $pdf->Output();
            // Masuk daftar lampiran
            $lampiran = $koneksi->prepare("INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran)
            VALUES (?, ?, ?, ?, ?, ?, ?)");
            $jenis_lampiran = 'Pengajuan Surat';
            $strip = 'Surat Pengantar/Keterangan';
            $lampiran->bind_param('sssssss', $cek_nik, $id, $filename, $jenis_lampiran, $date, $status, $strip);
            $lampiran->execute();
            break;
        default:
        echo 'gk masuk';
            break;
    }
?>