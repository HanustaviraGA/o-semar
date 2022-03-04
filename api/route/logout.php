<?php

/**
 * Untuk Logout
 * 
 * @return json
 */
function logout()
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $response = Logout::api_post();
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
