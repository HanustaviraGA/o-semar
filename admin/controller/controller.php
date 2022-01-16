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
                            $sql = "INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran) 
                            VALUES('$nik', '$uniqid', '$new_filename', 'Laporan Masyarakat', '$tanggal', 'Pending', '-')";
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
                            move_uploaded_file($file_tmp,'../berkas/pengumuman'.$new_filename);
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
                            $sql = "INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran) 
                            VALUES('$nik', '$uniqid', '$new_filename', 'Pengajuan Surat', '$tanggal', 'Pending', '-')";
                            $query = mysqli_query($koneksi, $sql);
                            $sql_pelaporan = "INSERT INTO suratketerangan(no_surat, nik, id_rt, id_rw, jenis, keperluan, tanggal_pengajuan, tujuan, keterangan, status)
                            VALUES ('$uniqid', '$nik', '$rt', '$rw', '$jenis', '$keperluan', '$tanggal', '$tujuan', '$keterangan', 'Pending')";
                            $query_pelaporan = mysqli_query($koneksi, $sql_pelaporan);
                            header("Location: ../views/surat/index.php?pesan=Berhasil");
                        }
                        else{
                            header("Location: ../views/surat/index.php?pesan=Gagal");
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
                header("Location: ../views/surat/index.php?pesan=Sukses !");
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
                header("Location: ../views/surat/index.php?pesan=Sukses !");
                exit;
            }
            break;
        case 'hapus_surat' :
            $id = $data['id'];
            $sql = "DELETE FROM suratketerangan WHERE no_surat='$id'";
            $query = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
            if($query){
                header("Location: ../views/surat/index.php?pesan=Sukses");
                exit;
            }    
            break;
        // PDF
        case 'create_pdf_iuran':
            require_once 'fpdf.php';
            $pdf = new FPDF('P','mm',array(100,100));
            $pdf->AddPage();

            $id = $_GET['id'];
            $sql = "SELECT * FROM tagihan WHERE id_tagihan='$id'";
            $result = mysqli_query($koneksi, $sql);
            $identifikasi = mysqli_fetch_array($result);
            // Cek Nama
            $cek_nik = $identifikasi['nik'];
            $nama = "SELECT nama, alamat FROM penduduk WHERE nik='$cek_nik'";
            $result_nama = mysqli_query($koneksi, $nama);
            $identifikasi_nama = mysqli_fetch_array($result_nama);

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
                $lampiran = "INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran)
                VALUES ('$cek_nik', '$id', '$filename', 'Pembayaran Tagihan', '$date', '$status', '-')";
                $exec_lampiran = mysqli_query($koneksi, $lampiran);
                
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
                $lampiran = "INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran)
                VALUES ('$cek_nik', '$id', '$filename', 'Pembayaran Tagihan', '$date', '$status', '-')";
                $exec_lampiran = mysqli_query($koneksi, $lampiran);
            }
            break;
        case 'create_pdf_surat':
            include 'roman.php';
            require_once 'fpdf.php';
            $pdf = new FPDF('P','mm',array(210,297));
            $pdf->AddPage();

            $id = $_GET['id'];
            $sql = "SELECT * FROM suratketerangan WHERE no_surat='$id'";
            $result = mysqli_query($koneksi, $sql);
            $identifikasi = mysqli_fetch_array($result);
            // Cek Nama
            $cek_nik = $identifikasi['nik'];
            $nama = "SELECT nama, alamat, pekerjaan, jenis_kelamin, tempat_lahir, 
            tanggal_lahir, status_perkawinan, kewarganegaraan, no_kk, agama 
            FROM penduduk WHERE nik='$cek_nik'";
            $result_nama = mysqli_query($koneksi, $nama);
            $identifikasi_nama = mysqli_fetch_array($result_nama);

            // Mssetting
            $nama_daerah = "SELECT * FROM mssettings";
            $exec_daerah = mysqli_query($koneksi, $nama_daerah);
            $fetch_daerah = mysqli_fetch_array($exec_daerah);
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
            
            // Surat
            $total = $identifikasi['jenis'];
            $jenis = $identifikasi['keperluan'];
            $tujuan = $identifikasi['tujuan'];
            $status = $identifikasi['tanggal_pengajuan'];
            $rekening = $identifikasi['keterangan'];

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
            $pdf->Cell( 0, 3, 'Tempat / Tanggal Lahir  : '.$tempat_lahir.' / '.$tanggal_lahir, 0, 0, 'J');
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
            $pdf->Cell( 0, 3, 'Nomor KK / KTP           : '.$cek_nik, 0, 0, 'J');
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
            $pdf->Cell( 0, 3, 'Tanda tangan.'.'                                                                                             '.$kabkota_akhir.'.......................... 20.........', 0, 0, 'J');
            $pdf->Ln(7);
            $pdf->cell(7,0.5);
            $pdf->Cell( 0, 3, 'yang bersangkutan                                                                                                            Ketua RT', 0, 0, 'J');
            $pdf->Ln(20);
            $pdf->Cell( 0, 3, '(.........................................)                                                                                      (.........................................)', 0, 0, 'J');
            $pdf->Ln(10);
            $pdf->Cell( 0, 3, 'No. : ...... / 402 / 96.06 / 03.V / 20 .....', 0, 0, 'J');
            $pdf->Ln(15);
            $pdf->Cell( 0, 3, 'Mengetahui', 0, 0, 'C');
            $pdf->Ln(7);
            $pdf->Cell( 0, 3, 'Ketua RW. '.$nomor_rw, 0, 0, 'C');
            $pdf->Ln(20);
            $pdf->Cell( 0, 3, '(.........................................)', 0, 0, 'C');
            // File
            $date = date('Y-m-d');
            $filename=$id.'_'.$cek_nik.'.pdf';
            $pdf->Output('F', '../berkas/iuran/' . $filename, true);
            $pdf->Output();
            // Masuk daftar lampiran
            $lampiran = "INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran)
            VALUES ('$cek_nik', '$id', '$filename', 'Pembayaran Tagihan', '$date', '$status', '-')";
            $exec_lampiran = mysqli_query($koneksi, $lampiran);
            break;
        default:
        echo 'gk masuk';
            break;
    }
?>