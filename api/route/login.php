<?php

require_once '../controller/Login.php';

/**
 * Login ke akun
 * 
 * @return json
 */
function login() {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $response = Login::api_post();
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
