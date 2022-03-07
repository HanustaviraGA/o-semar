<?php

require_once '../controller/Profile.php';

function profile()
{
    session_start();
    $profile = new Profile();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!isset($_SESSION['nik'])) {
            header("HTTP/ 401");
            header('Content-Type: application/json');
            echo json_encode(array(
                'msg' => 'Not Authorized'
            ));
            die;
        }
        $response = $profile->api_post();
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
