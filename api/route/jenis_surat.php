<?php

require_once '../controller/Jenis_Surat.php';

function jenis_surat()
{
    session_start();
    $jenis_surat = new JenisSurat();

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        if (!isset($_SESSION['nik'])) {
            header("HTTP/ 401");
            header('Content-Type: application/json');
            echo json_encode(array(
                'msg' => 'Not Authorized'
            ));
            die;
        }
        $response = $jenis_surat->api_get();
        if (!$response->status) {
            header("HTTP/ 400");
        } else {
            header("HTTP/ 200");
        }
        header('Content-Type: application/json');
        echo json_encode($response);
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
