<?php

/**
 * Untuk melihat data keluarga
 * 
 * @return json
 */
function lihat_kk()
{
    global $koneksi;
    // Tangkap NO KK
    $kk = $_POST['no_kk'];
    $esc_kk = mysqli_real_escape_string($koneksi, $kk);
    $sql = "SELECT * FROM penduduk WHERE no_kk = ?";
    $data = query($koneksi, $sql, 's', [$esc_kk]);
    if ($data) {
        $response = generate_response(1, 'Sukses', $data);
    } else {
        $response = generate_response(0, 'Gagal', $data);
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
