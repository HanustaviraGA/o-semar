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
    // Pencegahan SQL Injection
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    
    // Ek
    $result = "INSERT INTO penduduk SET
    nik = '$_POST[nik]',
    nama = '$_POST[nama]',
    tempat_lahir = '$_POST[tempat_lahir]'";
    $query = $koneksi->query($result);
    if ($query) {
        $response=array(
            'status' => 1,
            'message' => 'registrasinya berhasil beb <3'
        );
    }else{
        $response=array(
            'status' => 0,
            'message' => 'gagal regis :('
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>