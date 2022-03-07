<?php

require_once '../controller/Logout.php';

/**
 * Untuk Logout
 * 
 * @return json
 */
function logout()
{
    session_start();
    $logout = new Logout();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!isset($_SESSION['nik'])) {
            header("HTTP/ 401");
            header('Content-Type: application/json');
            echo json_encode(array(
                'msg' => 'Not Authorized'
            ));
            die;
        }
        $response = $logout->api_post();
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
