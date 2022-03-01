<?php

/**
 * Untuk melihat pengumuman
 * 
 * @return json
 */
function lihat_pengumuman()
{
    global $koneksi;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $rt = $_POST['id_rt'];
        $rw = $_POST['id_rw'];

        $sql = "SELECT * FROM pengumuman WHERE id_rt = ? AND id_rw = ?";
        $data = query($koneksi, $sql, 'ss', [$rt, $rw]);
        if ($data) {
            $response = generate_response(1, 'Sukses', $data);
            header("HTTP/ 200");
        } else {
            $response = generate_response(0, 'Gagal');
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
