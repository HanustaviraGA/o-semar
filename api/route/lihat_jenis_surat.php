<?php

/**
 * Untuk melihat pengumuman
 * 
 * @return json
 */
function lihat_jenis_surat()
{
    global $koneksi;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $sql = "SELECT jenis, keterangan_jenis FROM jenis_surat WHERE identifier = ?";
        $data = query($koneksi, $sql, 's', ['1']);
        if ($data) {
            $response = generate_response(1, 'Sukses', $data);
            header("HTTP/ 200");
        } else {
            $response = generate_response(0, 'Tidak ada Data');
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
