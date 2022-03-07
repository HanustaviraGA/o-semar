<?php

require_once '../controller/Register.php';

/**
 * Registrasi penduduk
 * 
 * @return json
 */
function register()
{
    $register = new Register();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $response = $register->api_post();
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
