<?php

function jenis_surat() {
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $response = JenisSurat::api_get();
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