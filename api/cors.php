<?php

function cors() {
    // Debug
    $_ENV['BASEURL'] = "http://localhost";
    if (isset($_SESSION['HTTP_ORIGIN']) && $_SESSION['HTTP_ORIGIN'] == $_ENV['BASEURL']) {
        header("Access-Control-Allow-Origin: {$_ENV['BASEURL']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400'); // Cache for 1 day
    } else {
        header("HTTP/ 403");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }
}