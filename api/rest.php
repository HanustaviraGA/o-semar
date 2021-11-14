<?php 

require_once "../koneksi.php";

$masuk = $_REQUEST;

if(function_exists($_GET['function'])){
    if (empty($_GET['key'])) {
        echo 'key is required';
    }else{
        if ($_GET['key'] == 'buwinakeren') {
            $_GET['function']();
        } else {
            echo 'unauthorized access';
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

    $sql = "SELECT * FROM penduduk";

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
    $no_kk = $_POST['no_kk'];
    $nik = $_POST['nik'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Pencegahan SQL Injection
    $cek_nokk = mysqli_real_escape_string($koneksi, $no_kk);
    $cek_nik = mysqli_real_escape_string($koneksi, $nik);
    $cek_username = mysqli_real_escape_string($koneksi, $username);
    $cek_password = mysqli_real_escape_string($koneksi, $password);
    // Encode
    $encode_nokk = base64_encode($cek_nokk);
    $encode_nik = base64_encode($cek_nik);
    $encode_password = base64_encode($cek_password);
    // Eksekusi
    $result = "INSERT INTO penduduk SET
    no_kk = $encode_nokk,
    nik = '$encode_nik', 
    username = '$cek_username', 
    password = '$encode_password'";
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
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>