<?php 

require_once "../koneksi.php";

$masuk = $_REQUEST;

if(function_exists($_GET['function'])){
    if (empty($_GET['key'])) {
        echo 'Key is required';
      	$response=array(
            'status' => 403,
            'message' => 'Forbidden'
        );
    }else{
        if (base64_encode($_GET['key']) == 'YnV3aW5ha2VyZW4=') {
            $_GET['function']();
        } else {
            echo 'unauthorized access';
          	$response=array(
            'status' => 401,
            'message' => 'Unauthorized'
        );
        }
    }
}

function generate_response($status, $message, $data = []) {
    return array(
        'status' => $status,
        'message' => $message,
        'data' => $data
    );
}

function get_penduduk_data(){
    global $koneksi;

    $filter_key = empty($_GET["filter_key"]) ? null : $_GET['filter_key'];
    $filter_value = empty($_GET["filter_value"]) ? null : $_GET['filter_value'];

    $sql = "SELECT no_kk, nik, nama, tempat_lahir, tanggal_lahir, alamat, id_rt, id_rw, jenis_kelamin, agama, status_perkawinan, pekerjaan, gol_darah, kewarganegaraan, status_ktp, foto_ktp, email, username, no_hp, tanggal_reg FROM penduduk";

    if ($filter_key != null && $filter_value != null) {
        $sql .= " WHERE $filter_key = '$filter_value'";
    }

    $query = $koneksi->query($sql);
    while($row = mysqli_fetch_object($query)){
        $data[] = $row;
    }

    if($data){
        $response=generate_response(1, 'Sukses', $data);
    }else{
        $response=generate_response(0, 'Tidak ada Data', $data);
    }
    header('content-type: application/json');
    echo json_encode($response);
}

function register(){
    global $koneksi;
    // Ambil Data
    $no_kk = $_POST['no_kk'];
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Pencegahan SQL Injection
    $cek_no_kk = mysqli_real_escape_string($koneksi, $no_kk);
    $cek_nik = mysqli_real_escape_string($koneksi, $nik);
    $cek_nama = mysqli_real_escape_string($koneksi, $nama);
    $cek_email = mysqli_real_escape_string($koneksi, $email);
    $cek_username = mysqli_real_escape_string($koneksi, $username);
    $cek_password = mysqli_real_escape_string($koneksi, $password);
    
    // Periksa Duplikat
    $cek_id = "SELECT * FROM penduduk WHERE no_kk = '$cek_no_kk' AND nik = '$cek_nik' AND nama = '$cek_nama' AND username = '$cek_username'";
    // Eksekusi Registrasi
    $result = "INSERT INTO penduduk SET no_kk = '$cek_no_kk', nik = '$cek_nik', nama = '$cek_nama', email = '$cek_email', username = '$cek_username', password = '$cek_password'";
    
    $exec_cek = $koneksi->query($cek_id);
    $count = mysqli_num_rows($exec_cek);
    if($count > 0){
        $response=array(
            'status' => 2,
            'message' => 'Terdapat Pengguna dengan Data yang Sama'
        );
    }else{
        $query = $koneksi->query($result);
        if ($query) {
            $response=array(
                'status' => 1,
                'message' => 'Registrasi Berhasil'
            );
        }else{
            $response=array(
                'status' => 0,
                'message' => 'Registrasi Gagal'
            );
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>