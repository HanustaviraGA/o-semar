<?php

/**
 * Registrasi penduduk
 * 
 * @return json
 */
function register()
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $response = Register::api_post();
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
