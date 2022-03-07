<?php

require_once '../controller/Laporan.php';

/**
 * Untuk olah laporan
 * 
 * @return json
 */
function laporan()
{
    session_start();
    $laporan = new Laporan();

    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        if (!isset($_SESSION['nik'])) {
            header("HTTP/ 401");
            header('Content-Type: application/json');
            echo json_encode(array(
                'msg' => 'Not Authorized'
            ));
            die;
        }
        $response = $laporan->api_get();
        if (!$response->status)
            header("HTTP/ 400");
        else
            header("HTTP/ 200");
        header('Content-Type: application/json');
        echo json_encode($response);
    } else if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!isset($_SESSION['nik'])) {
            header("HTTP/ 401");
            header('Content-Type: application/json');
            echo json_encode(array(
                'msg' => 'Not Authorized'
            ));
            die;
        }
        $response = $laporan->api_post();
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
