<?php 

require_once "../koneksi.php";
require_once "./query.php";
require_once "./generate_response.php";

$masuk = $_REQUEST;

/**
 * Cek jika variabel function dan key ada pada GET Request
 */
if(!empty($_GET['function']) && function_exists($_GET['function'])){
    if (empty($_GET['key'])) {
        echo '<p>Key is required</p>';
      	$response = array(
            'status' => 403,
            'message' => 'Forbidden'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        if (base64_encode($_GET['key']) == 'YnV3aW5ha2VyZW4=') {
            $_GET['function']();
        } else {
          	$response = array(
                'status' => 401,
                'message' => 'Unauthorized access'
            );
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
} else {
        $response = array(
        'status' => 404,
        'message' => 'Not Found'
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

/**
 * Kembalikan data penduduk
 * 
 * @return json
 */
function get_penduduk_data(){
    global $koneksi;

    $filter_key = empty($_GET["filter_key"]) ? null : $_GET['filter_key'];
    $filter_value = empty($_GET["filter_value"]) ? null : $_GET['filter_value'];

    $sql = "SELECT no_kk, nik, nama, tempat_lahir, tanggal_lahir, alamat, id_rt, id_rw, jenis_kelamin, agama, status_perkawinan, pekerjaan, gol_darah, kewarganegaraan, status_ktp, foto_ktp, email, username, no_hp, tanggal_reg FROM penduduk";

    // Unsecure code
    // if ($filter_key != null && $filter_value != null) {
    //     $sql .= " WHERE $filter_key = '$filter_value'";
    // }

    // $query = $koneksi->query($sql);
    // while($row = mysqli_fetch_object($query)){
    //     $data[] = $row;
    // }

    if ($filter_key != null && $filter_value != null) {
        $sql .= " WHERE $filter_key = ?";
        $data = query($koneksi, $sql, 's', [$filter_value]);
    } else {
        $data = query($koneksi, $sql);
    }

    if($data){
        $response = generate_response(1, 'Sukses', $data);
    }else{
        $response = generate_response(0, 'Tidak ada Data', $data);
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

/**
 * Registrasi penduduk
 * 
 * @return json
 */
function register(){
    global $koneksi;
    // Ambil Data
    $no_kk = $_POST['no_kk'];
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Escape simbol dari query
    $cek_no_kk = mysqli_real_escape_string($koneksi, $no_kk);
    $cek_nik = mysqli_real_escape_string($koneksi, $nik);
    $cek_nama = mysqli_real_escape_string($koneksi, $nama);
    $cek_email = mysqli_real_escape_string($koneksi, $email);
    $cek_username = mysqli_real_escape_string($koneksi, $username);
    $cek_password = mysqli_real_escape_string($koneksi, $password);
    // Enkripsi
    $hash_pw = hash('sha256', $cek_password);
    
    // Unsecure Code - Periksa Duplikat
    // $cek_id = "SELECT * FROM penduduk WHERE no_kk = '$cek_no_kk' AND nik = '$cek_nik' AND nama = '$cek_nama' AND username = '$cek_username'";
    // $exec_cek = $koneksi->query($cek_id);
    // $count = mysqli_num_rows($exec_cek);
    
    // Unsecure Code - Eksekusi Registrasi
    // $result = "INSERT INTO penduduk SET no_kk = '$cek_no_kk', nik = '$cek_nik', nama = '$cek_nama', email = '$cek_email', username = '$cek_username', password = '$hash_pw'";
    // Periksa Duplikat
    $count = query(
            $koneksi, 
            "SELECT * FROM penduduk WHERE no_kk = ? AND nik = ? AND nama = ? AND username = ?",
            'ssss',
            [$cek_no_kk, $cek_nik, $cek_nama, $cek_username]
        );
    if (count($count) > 0) {
        $response = [
            'status' => 2,
            'message' => 'Terdapat Pengguna dengan Data yang Sama'
        ];
    } else {
        $query = query($koneksi, 
            "INSERT INTO penduduk SET no_kk = ?, nik = ?, nama = ?, email = ?, username = ?, password = ?",
            'ssssss',
            [$cek_no_kk, $cek_nik, $cek_nama, $cek_email, $cek_username, $hash_pw]
        );
        if ($query) {
            $response = [
                'status' => 1,
                'message' => 'Registrasi Berhasil'
            ];
        } else {
            $response = [
                'status' => 0,
                'message' => 'Registrasi Gagal'
            ];
        }
    }
    // if($count > 0){
    //     $response=array(
    //         'status' => 2,
    //         'message' => 'Terdapat Pengguna dengan Data yang Sama'
    //     );
    // }else{
    //     $query = $koneksi->query($result);
    //     if ($query) {
    //         $response=array(
    //             'status' => 1,
    //             'message' => 'Registrasi Berhasil'
    //         );
    //     }else{
    //         $response=array(
    //             'status' => 0,
    //             'message' => 'Registrasi Gagal'
    //         );
    //     }
    // }
    header('Content-Type: application/json');
    echo json_encode($response);
}

/**
 * Login ke akun penduduk
 * 
 * @return json
 */
function login() {
    global $koneksi;
    if(isset($_POST['username']) && $_POST['password']){
        // Tangkap kiriman data dan antisipasi SQL injection
        $username = $_POST['username'];
        $password = $_POST['password'];
        $esc_username = mysqli_real_escape_string($koneksi, $username);
        $esc_password = mysqli_real_escape_string($koneksi, $password);
        $hash_pw = hash('sha256', $esc_password);
        // Unsecure code - Cek database
        // $query = "SELECT no_kk, nik, nama, tempat_lahir, tanggal_lahir, 
        // alamat, id_rt, id_rw, jenis_kelamin, agama, status_perkawinan, 
        // pekerjaan, gol_darah, kewarganegaraan, status_ktp, foto_ktp, 
        // email, username, no_hp, status_hubungan_keluarga, no_paspor, no_kitas,
        // no_kitas, kepala_keluarga, nama_ayah, nama_ibu, virtual_account_id, foto_kk, 
        // pendidikan, tanggal_pengeluaran_kk, tanggal_reg 
        // FROM penduduk WHERE username='$esc_username' AND password='$hash_pw'";
        // $result = mysqli_query($koneksi,$query);
        // $data = mysqli_fetch_assoc($result);
        
        // Cek database
        $query = "SELECT no_kk, nik, nama, tempat_lahir, tanggal_lahir, 
        alamat, id_rt, id_rw, jenis_kelamin, agama, status_perkawinan, 
        pekerjaan, gol_darah, kewarganegaraan, status_ktp, foto_ktp, 
        email, username, no_hp, status_hubungan_keluarga, no_paspor, no_kitas,
        no_kitas, kepala_keluarga, nama_ayah, nama_ibu, virtual_account_id, foto_kk, 
        pendidikan, tanggal_pengeluaran_kk, tanggal_reg 
        FROM penduduk WHERE username = ? AND password = ?";
        $data = query($koneksi, $query, 'ss', [$esc_username, $hash_pw]);
        if($data){
            session_start();
            session_regenerate_id(true);
            $_SESSION['keadaan'] = "sudah_login_penduduk";
            $response = generate_response(1, 'Sukses', $data);
            header('Content-Type: application/json');
            echo json_encode($response);
        }else{
            $response = generate_response(0, 'Gagal');
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }else{
        $response = generate_response(3, 'Kosong');
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

/**
 * Untuk Logout
 * 
 * @return json
 */
function logout() {
    session_unset();
    session_destroy();
    $response = generate_response(1, 'Sukses');
    header('Content-Type: application/json');
    echo json_encode($response);
}

/**
 * Untuk melihat data keluarga
 * 
 * @return json
 */
function lihat_kk(){
    global $koneksi;
    // Tangkap NO KK
    $kk = $_POST['no_kk'];
    $esc_kk = mysqli_real_escape_string($koneksi, $kk);
    // Unsecure Code
    // $sql = "SELECT * FROM penduduk WHERE no_kk = '$esc_kk'";
    // $query = $koneksi->query($sql);
    // while($row = mysqli_fetch_object($query)){
    //     $data[] = $row;
    // }
    $sql = "SELECT * FROM penduduk WHERE no_kk = ?";
    $data = query($koneksi, $sql, 's', [$esc_kk]);
    if($data){
        $response = generate_response(1, 'Sukses', $data);
    } else {
        $response = generate_response(0, 'Gagal', $data);
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

/**
 * Untuk membuat surat
 * 
 * @return json
 */
function buat_surat(){
    global $koneksi;
    // Ambil data form
    $jenis = $_POST['jenis'];
    $nik = $_POST['nik'];
    $rt = $_POST['id_rt'];
    $rw = $_POST['id_rw'];
    $tanggal = date("Y-m-d");
    $keterangan = $_POST['keterangan'];
    $keperluan = $_POST['keperluan'];
    // Default value
    $prefix = 'SRT';
    $uniqid = uniqid($prefix);
    // Masukkan tabel di DB
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
                move_uploaded_file($file_tmp,'../admin/surat/berkas/'.$new_filename);
                // Masuk Lampiran
                $sql = "INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran) 
                VALUES('$nik', '$uniqid', '$new_filename', 'Pengajuan Surat', '$tanggal', 'Pending', '-')";
                $query = mysqli_query($koneksi, $sql);
                // Unsecure Code - Masuk Surat Keterangan
                // $sql_pelaporan = "INSERT INTO suratketerangan(no_surat, nik, id_rt, id_rw, jenis, keperluan, tanggal_pengajuan, keterangan, status)
                // VALUES ('$uniqid', '$nik', '$rt', '$rw', '$jenis', '$keperluan', '$tanggal', '$keterangan', 'Pending')";
                // $query_pelaporan = mysqli_query($koneksi, $sql_pelaporan);

                // Masuk Surat Keterangan
                $sql_pelaporan = "INSERT INTO suratketerangan(no_surat, nik, id_rt, id_rw, jenis, keperluan, tanggal_pengajuan, keterangan, status, alasan)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending', '-')";
                $query_pelaporan = query($koneksi, $sql_pelaporan, 'ssssssss', [$uniqid, $nik, $rt, $rw, $jenis, $keperluan, $tanggal, $keterangan]);
                $response  = generate_response(1, 'Sukses');
                header('Content-Type: application/json');
                echo json_encode($response);
            }
            else{
                $response = generate_response(2, 'Ekstensi file tidak dapat diterima');
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
    } else {
        // Unsecure Code - Masuk Surat Keterangan
        // $sql_pelaporan = "INSERT INTO suratketerangan(no_surat, nik, id_rt, id_rw, jenis, keperluan, tanggal_pengajuan, keterangan, status)
        // VALUES ('$uniqid', '$nik', '$rt', '$rw', '$jenis', '$keperluan', '$tanggal', '$keterangan', 'Pending')";
        // $query_pelaporan = mysqli_query($koneksi, $sql_pelaporan);

        // Masuk Surat Keterangan
        $sql_pelaporan = "INSERT INTO suratketerangan(no_surat, nik, id_rt, id_rw, jenis, keperluan, tanggal_pengajuan, keterangan, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";
        $query_pelaporan = query($koneksi, $sql_pelaporan, 'ssssssss', [$uniqid, $nik, $rt, $rw, $jenis, $keperluan, $tanggal, $keterangan]);
        if($query_pelaporan){
            $response = generate_response(1, 'Sukses');
            header('Content-Type: application/json');
            echo json_encode($response);
        }else{
            $response = generate_response(0, 'Gagal');
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
}

/**
 * Untuk melihat daftar surat yang ada
 * 
 * @return json
 */
function lihat_daftar_surat(){
    global $koneksi;
    $nik = $_POST['nik'];
    $esc_nik = mysqli_real_escape_string($koneksi, $nik); 
    // Unsecure Code
    // $sql = "SELECT * FROM suratketerangan WHERE nik=$esc_nik";
    // $query = $koneksi->query($sql);
    // while($row = mysqli_fetch_object($query)){
    //     $data[] = $row;
    // }

    $sql = "SELECT * FROM suratketerangan WHERE nik = ?";
    $data = query($koneksi, $sql, 's', [$esc_nik]);
    if($data){
        $response = generate_response(1, 'Sukses', $data);
    }else{
        $response = generate_response(0, 'Gagal');
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

/**
 * Untuk membuat laporan
 * 
 * @return json
 */
function buat_laporan(){
    global $koneksi;
    // Ambil data form
    $nik = $_POST['nik'];
    $rt = $_POST['id_rt'];
    $rw = $_POST['id_rw'];
    $kategori = $_POST['kategori'];
    $keterangan = $_POST['keterangan'];
    $tanggal = date("Y-m-d");
    // Default value
    $prefix = 'LPR';
    $uniqid = uniqid($prefix);
    // Masukkan tabel di DB
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
                move_uploaded_file($file_tmp,'../admin/laporan/berkas/'.$new_filename);
                // Unsecure Code - Masuk Lampiran
                // $sql = "INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran) 
                // VALUES('$nik', '$uniqid', '$new_filename', 'Laporan Masyarakat', '$tanggal', 'Pending', '-')";
                // $query = mysqli_query($koneksi, $sql);

                // Masuk Lampiran
                $sql = "INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran) 
                VALUES(?, ?, ?, 'Laporan Masyarakat', ?, 'Pending', '-')";
                $query = query($koneksi, $sql, 'ssss', [$nik, $uniqid, $new_filename, $tanggal]);
                // Unsecure Code - Masuk Pelaporan
                // $sql_pelaporan = "INSERT INTO pelaporan(id_pelaporan, nik, id_rt, id_rw, kategori, keterangan, tanggal_pelaporan, status)
                // VALUES ('$uniqid', '$nik', '$rt', '$rw', '$kategori', '$keterangan', '$tanggal', 'Pending')";
                // $query_pelaporan = mysqli_query($koneksi, $sql_pelaporan);

                $sql_pelaporan = "INSERT INTO pelaporan(id_pelaporan, nik, id_rt, id_rw, kategori, keterangan, tanggal_pelaporan, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')";
                $query_pelaporan = query($koneksi, $sql_pelaporan, 'sssssss', [$uniqid, $nik, $rt, $rw, $kategori, $keterangan, $tanggal]);

                $response = generate_response(1, 'Sukses');
                header('Content-Type: application/json');
                echo json_encode($response);
            }
            else{
                $response = generate_response(2, 'Ekstensi file tidak dapat diterima');
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
    } else {
        // Unsecure Code - Masuk Surat Keterangan
        // $sql_pelaporan = "INSERT INTO pelaporan(id_pelaporan, nik, id_rt, id_rw, kategori, keterangan, tanggal_pelaporan, status)
        // VALUES ('$uniqid', '$nik', '$rt', '$rw', '$kategori', '$keterangan', '$tanggal', 'Pending')";
        // $query_pelaporan = mysqli_query($koneksi, $sql_pelaporan);

        // Masuk Surat Keterangan
        $sql_pelaporan = "INSERT INTO pelaporan(id_pelaporan, nik, id_rt, id_rw, kategori, keterangan, tanggal_pelaporan, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')";
        $query_pelaporan = query($koneksi, $sql_pelaporan, 'sssssss', [$uniqid, $nik, $rt, $rw, $kategori, $keterangan, $tanggal]);
        if($query_pelaporan){
            $response = generate_response(1, 'Sukses');
            header('Content-Type: application/json');
            echo json_encode($response);
        }else{
            $response = generate_response(0, 'Gagal');
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
}

function lihat_iuran(){
    global $koneksi;
}

/**
 * Untuk melihat pengumuman
 * 
 * @return json
 */
function lihat_pengumuman(){
    global $koneksi;
    $rt = $_POST['id_rt'];
    $rw = $_POST['id_rw'];
    // Unsecure Code
    // $sql = "SELECT * FROM pengumuman WHERE id_rt=$rt AND id_rw = $rw";
    // $query = $koneksi->query($sql);
    // while($row = mysqli_fetch_object($query)){
    //     $data[] = $row;
    // }

    $sql = "SELECT * FROM pengumuman WHERE id_rt = ? AND id_rw = ?";
    $data = query($koneksi, $sql, 'ss', [$rt, $rw]);
    if($data){
        $response = generate_response(1, 'Sukses', $data);
    } else {
        $response = generate_response(0, 'Gagal');
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
