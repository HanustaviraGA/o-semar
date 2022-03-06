<?php

function penduduk() {
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        if (!isset($_SESSION['nik'])) {
            header("HTTP/ 401");
            header('Content-Type: application/json');
            echo json_encode(array(
                'msg' => 'Not Authorized'
            ));
            die;
        }
        $response = Penduduk::api_get();
        if (!$response->status)
            header("HTTP/ 400");
        else
            header("HTTP/ 200");
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