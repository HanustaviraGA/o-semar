<?php

/**
 * Untuk olah laporan
 * 
 * @return json
 */
function laporan() {
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $response = Laporan::api_get();
        if (!$response->status)
            header("HTTP/ 400");
        else
            header("HTTP/ 200");
        header('Content-Type: application/json');
        echo json_encode($response);
    } else if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $response = Laporan::api_post();
        if (!$response->status) {
            header("HTTP/ 400");
        } else {
            header("HTTP/ 201");
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