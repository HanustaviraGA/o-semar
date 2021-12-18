<?php

/**
 * Kembalikan data penduduk
 * 
 * @return json
 */
function get_penduduk_data()
{
    global $koneksi;

    $filter_key = empty($_GET["filter_key"]) ? null : $_GET['filter_key'];
    $filter_value = empty($_GET["filter_value"]) ? null : $_GET['filter_value'];

    $sql = "SELECT no_kk, nik, nama, tempat_lahir, tanggal_lahir, alamat, id_rt, id_rw, jenis_kelamin, agama, status_perkawinan, pekerjaan, gol_darah, kewarganegaraan, status_ktp, foto_ktp, email, username, no_hp, tanggal_reg FROM penduduk";

    if ($filter_key != null && $filter_value != null) {
        $sql .= " WHERE $filter_key = ?";
        $data = query($koneksi, $sql, 's', [$filter_value]);
    } else {
        $data = query($koneksi, $sql);
    }

    if ($data) {
        $response = generate_response(1, 'Sukses', $data);
    } else {
        $response = generate_response(0, 'Tidak ada Data', $data);
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}