<?php	
    include '../../koneksi.php';
    session_start();
    $nik = $_SESSION['nik'];
    $rt = $_SESSION['rt'];
    $rw = $_SESSION['rw'];
    $tanggal = date("Y-m-d");
    if(isset($_POST['submit'])){
        $kategori = $_POST['kategori'];
        $nama = $_POST['nama'];
        $keterangan = $_POST['keterangan'];
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
                    move_uploaded_file($file_tmp,'berkas/'.$new_filename);
                    // Masuk Lampiran
                    $sql = "INSERT INTO lampiran(nik, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran) 
                    VALUES('$nik', '$new_filename', 'Laporan Masyarakat', '$tanggal', 'Pending', '-')";
                    $query = mysqli_query($koneksi, $sql);
                    $sql_pelaporan = "INSERT INTO pelaporan(id_pelaporan, nik, id_rt, id_rw, kategori, keterangan, tanggal_pelaporan, status)
                    VALUES ('$uniqid', '$nik', '$rt', '$rw', '$kategori', '$keterangan', '$tanggal', 'Pending')";
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
?>