<?php

    /**
 * Untuk melihat pengumuman
 * 
 * @return json
 */
function lihat_pengumuman()
{
    global $koneksi;
    $rt = $_POST['id_rt'];
    $rw = $_POST['id_rw'];

    $sql = "SELECT * FROM pengumuman WHERE id_rt = ? AND id_rw = ?";
    $data = query($koneksi, $sql, 'ss', [$rt, $rw]);
    if ($data) {
        $response = generate_response(1, 'Sukses', $data);
    } else {
        $response = generate_response(0, 'Gagal');
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
