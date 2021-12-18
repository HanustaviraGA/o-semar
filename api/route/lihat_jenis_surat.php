<?php

/**
 * Untuk melihat pengumuman
 * 
 * @return json
 */
function lihat_jenis_surat()
{
    global $koneksi;
    $sql = "SELECT jenis, keterangan_jenis FROM jenis_surat WHERE identifier = ?";
    $data = query($koneksi, $sql, 's', ['1']);
    if ($data) {
        $response = generate_response(1, 'Sukses', $data);
    } else {
        $response = generate_response(0, 'Tidak ada Data');
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
