<?php

require_once "../koneksi.php";
require_once "./query.php";
require_once "./generate_response.php";
require_once "./cors.php";
require_once "./route/get_penduduk_data.php";
require_once "./route/register.php";
require_once "./route/login.php";
require_once "./route/logout.php";
require_once "./route/lihat_kk.php";
require_once "./route/lihat_daftar_surat.php";
require_once "./route/lihat_daftar_laporan.php";
require_once "./route/lihat_iuran.php";
require_once "./route/lihat_jenis_surat.php";
require_once "./route/lihat_pengumuman.php";
require_once "./route/buat_surat.php";
require_once "./route/buat_laporan.php";
require_once "./route/update_iuran.php";
require_once "./route/update_profile.php";


$masuk = $_REQUEST;

/**
 * Cek jika variabel function dan key ada pada GET Request
 */
if (!empty($_GET['function']) && function_exists($_GET['function'])) {
    if (empty($_GET['key'])) {
        echo '<p>Key is required</p>';
        $response = array(
            'status' => 403,
            'message' => 'Forbidden'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        if (base64_encode($_GET['key']) == 'YnV3aW5ha2VyZW4=') {
            $_GET['function']();
        } else {
            $response = array(
                'status' => 401,
                'message' => 'Unauthorized access'
            );
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
} else {
    $response = array(
        'status' => 404,
        'message' => 'Not Found'
    );
    header('Content-Type: application/json');
    header('HTTP/ 404');
    echo json_encode($response);
}