<?php

/**
 * Untuk melihat data keluarga
 * 
 * @return json
 */
function lihat_kk()
{
    global $koneksi;
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Tangkap NO KK
        $kk = $_POST['no_kk'];
        $esc_kk = mysqli_real_escape_string($koneksi, $kk);
        $sql = "SELECT * FROM penduduk WHERE no_kk = ?";
        $data = query($koneksi, $sql, 's', [$esc_kk]);
        if ($data) {
            $response = generate_response(1, 'Sukses', $data);
            header("HTTP/ 200");
        } else {
            $response = generate_response(0, 'Gagal', $data);
            header("HTTP/ 500");
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    } else {
        header("HTTP/ 405");
        header("Content-Type: application/json");
        echo json_encode(array(
            "status" => 405,
            "msg" => "Method Not Allowed"
        ));
        exit();
    }
}
