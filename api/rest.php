<?php 

require_once "../koneksi.php";

$masuk = $_REQUEST;

if(function_exists($_GET['function'])){
    $_GET['function']();
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

    $response=array(
        'status' => 1,
        'message' => 'Sukses',
        'data' => $data
    );
    header('content-type: application/json');
    echo json_encode($response);
}

function generate_response($status, $message, $data = []) {
    return array(
        'status' => $status,
        'message' => $message,
        'data' => $data
    );
}

function regist_admin(){
    global $koneksi;
    $check = array('id' => '','nama' => '','nik' => '','email' => '','katasandi' => '','c_sandi' => '','kk' => '','username' => '','alamat' => '','tempatlahir' => '','tanggallahir' => '','gender' => '','posisi' => '');
    $check_match = count(array_intersect_key($_POST, $check));
    if ($check_match == count($check)) {
        $result = mysqli_query($koneksi, "INSERT INTO admin SET
        id = '$_POST[id]',
        nama = '$_POST[nama]',
        nik = '$_POST[nik]',
        email = '$_POST[email]',
        katasandi = '$_POST[katasandi]',
        c_sandi = '$_POST[c_sandi]',
        username = '$_POST[username]',
        alamat = '$_POST[alamat]',
        tempatlahir = '$_POST[tempatlahir]',
        tanggallahir = '$_POST[tanggallahir]',
        gender = '$_POST[gender]',
        posisi = '$_POST[posisi]'");

        if ($result) {
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
    }else{
        $response=array(
            'status' => 0,
            'message' => 'parameternya salah'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function update_admin(){
    global $koneksi;
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
    }
    $check = array('id' => '','nama' => '','nik' => '','email' => '','katasandi' => '','c_sandi' => '','kk' => '','username' => '','alamat' => '','tempatlahir' => '','tanggallahir' => '','gender' => '','posisi' => '');
    $check_match = count(array_intersect_key($_POST, $check));
    if ($check_match == count($check)) {
        $result = mysqli_query($koneksi, "UPDATE admin SET               
        id = '$_POST[id]',
        nama = '$_POST[nama]',
        nik = '$_POST[nik]',
        email = '$_POST[email]',
        katasandi = '$_POST[katasandi]',
        c_sandi = '$_POST[c_sandi]',
        username = '$_POST[username]',
        alamat = '$_POST[alamat]',
        tempatlahir = '$_POST[tempatlahir]',
        tanggallahir = '$_POST[tanggallahir]',
        gender = '$_POST[gender]',
        posisi = '$_POST[posisi]' WHERE id = $id");

        if ($result) {
            $response=array(
                'status' => 1,
                'message' =>'Berhasil di update beb' 
            );
        }else{
            $response=array(
                'status' => 0,
                'message' =>'yah.. gagal di update :('
            ); 
        }
    }else{
        $response=array(
            'status' => 0,
            'message' =>'parameternya salah gan',
            'data' => $id
        ); 
    }
}

function hapus_admin(){
    global $koneksi;
    $id = $_GET['id'];
    $query = "DELETE FROM admin WHERE id=".$id;

    if (mysqli_query($koneksi, $query)) {
        $response=array(
            'status' => 1,
            'message' =>'Berhasil di hapus wkwkw bye!'
        ); 
    }else{
        $response=array(
            'status' => 0,
            'message' =>'gagal wkwkw, banyak2 doa dah lu jangan ateis mulu'
        ); 
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}




?>