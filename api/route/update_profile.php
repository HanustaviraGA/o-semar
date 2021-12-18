<?php

/**
 * Untuk melihat pengumuman
 * 
 * @return json
 */

function update_profile()
{
    global $koneksi;
    //  Tangkap inputan filter
    $filter = $_POST['filter'];
    $esc_filter = mysqli_real_escape_string($koneksi, $filter);
    /*
    Jenis filter : 1 - Ganti profile, 2 - Ganti password
    */
    // Ganti profile  
    if ($esc_filter == 1) {
        //  Tangkap inputan pencarian data
        $nik = $_POST['nik'];
        // Escape inputan
        $esc_nik = mysqli_real_escape_string($koneksi, $nik);
        // Cek jika data ada
        $sql = "SELECT * FROM penduduk WHERE nik = ?";
        $data = query($koneksi, $sql, 's', [$esc_nik]);
        if ($data) {
            // Ambil data baru
            $nik_baru = $_POST['nik_baru'];
            $kk = $_POST['no_kk'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            // Escape inputan data data baru
            $esc_nik_baru = mysqli_real_escape_string($koneksi, $nik_baru);
            $esc_kk = mysqli_real_escape_string($koneksi, $kk);
            $esc_email = mysqli_real_escape_string($koneksi, $email);
            $esc_username = mysqli_real_escape_string($koneksi, $username);
            // Eksekusi
            $sql_upd = "UPDATE penduduk SET no_kk = ?, nik = ?, email = ?, username = ? WHERE nik = ?";
            $data = query($koneksi, $sql_upd, 'sssss', [$esc_kk, $esc_nik_baru, $esc_email, $esc_username, $esc_nik]);
            $response = generate_response(1, 'Sukses');
        } else {
            $response = generate_response(0, 'Tidak ada Data');
        }
        //  Ubah password
    } else if ($esc_filter == 2) {
        $nik = $_POST['nik'];
        // Cek jika data ada
        $sql = "SELECT * FROM penduduk WHERE nik = ?";
        $esc_nik = mysqli_real_escape_string($koneksi, $nik);
        $data = query($koneksi, $sql, 's', [$esc_nik]);
        if ($data) {
            $password = $_POST['password'];
            $esc_password = mysqli_real_escape_string($koneksi, $password);
            // Enkripsi
            $hash_pw = password_hash($esc_password, PASSWORD_DEFAULT);
            $sql_upd = "UPDATE penduduk SET password = ? WHERE nik = ?";
            $data_upd = query($koneksi, $sql_upd, 'ss', [$hash_pw, $esc_nik]);
            $response = generate_response(1, 'Sukses');
        } else {
            $response = generate_response(0, 'Tidak ada Data');
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
