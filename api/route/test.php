<?php

function test()
{
    session_start();
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        header("HTTP/ 200");
        header('Content-Type: application/json');
        echo json_encode(array(
            'msg' => 'Ini endpoint untuk mengetes jika anda berhasil mengakses API'
        ));
    } else if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!isset($_SESSION['nik'])) {
            header("HTTP/ 401");
            header('Content-Type: application/json');
            echo json_encode(array(
                'msg' => 'User tidak terautentikasi, coba login terlebih dahulu',
                'session' => $_SESSION
            ));
            die;
        }
        header("HTTP/ 200");
        header('Content-Type: application/json');
        echo json_encode(array(
            'msg' => 'Ini endpoint untuk mengetes jika anda berhasil mengakses API dan terautentikasi',
            'session' => $_SESSION
        ));
    } else {
        header("HTTP/ 405");
        header("Content-Type: application/json");
        echo json_encode(array(
            "status" => 405,
            "msg" => "Method Not Allowed"
        ));
    }
    die;
}
