<?php

/**
 * Registrasi penduduk
 * 
 * @return json
 */
function register()
{
    global $koneksi;
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Ambil Data
        $filter = $_POST['filter'];
        $no_kk = $_POST['no_kk'];
        $nik = $_POST['nik'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        // Escape simbol dari query
        $cek_no_kk = mysqli_real_escape_string($koneksi, $no_kk);
        $cek_nik = mysqli_real_escape_string($koneksi, $nik);
        $cek_nama = mysqli_real_escape_string($koneksi, $nama);
        $cek_email = mysqli_real_escape_string($koneksi, $email);
        $cek_username = mysqli_real_escape_string($koneksi, $username);
        $cek_password = mysqli_real_escape_string($koneksi, $password);
        // Enkripsi
        $hash_pw = password_hash($cek_password, PASSWORD_DEFAULT);
        // Periksa Duplikat
        $count = query(
            $koneksi,
            "SELECT * FROM penduduk WHERE no_kk = ? AND nik = ? AND nama = ? AND username = ?",
            'ssss',
            [$cek_no_kk, $cek_nik, $cek_nama, $cek_username]
        );
        if (count($count) > 0) {
            if ($filter == 1) {
                header("Location: ../admin/register?pesan=sama");
            } else if ($filter == 0) {
                $response = [
                    'status' => 2,
                    'message' => 'Terdapat Pengguna dengan Data yang Sama'
                ];
                header("HTTP/ 500");
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        } else {
            $query = query(
                $koneksi,
                "INSERT INTO penduduk SET no_kk = ?, nik = ?, nama = ?, email = ?, username = ?, password = ?",
                'ssssss',
                [$cek_no_kk, $cek_nik, $cek_nama, $cek_email, $cek_username, $hash_pw]
            );
            if ($query) {
                if ($filter == 1) {
                    header("Location: ../admin/views/login?pesan=sukses");
                } else if ($filter == 0) {
                    $response = [
                        'status' => 1,
                        'message' => 'Registrasi Berhasil'
                    ];
                    header("HTTP/ 201");
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            } else {
                if ($filter == 1) {
                    header("Location: ../admin/views/register?pesan=gagal");
                } else if ($filter == 0) {
                    $response = [
                        'status' => 0,
                        'message' => 'Registrasi Gagal'
                    ];
                    header("HTTP/ 500");
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            }
        }
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
