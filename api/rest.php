<?php

require_once "../koneksi.php";
require_once "../csrf.php";
require_once "./query.php";
require_once "./generate_response.php";
// Get all routes automaticly
foreach (new DirectoryIterator(__DIR__ . '/route') as $file)
    if ($file->isFile())
        require_once "./route/" . $file->getFilename();

/**
 * API Key dihapus karena tidak terlalu
 * berguna untuk melindungi API
 * 
 * Dialihkan dengan mengecek session user
 */

if (!empty($_GET['function']) && function_exists($_GET['function'])) {
    $_GET['function']();
} else {
    $response = array(
        'status' => 404,
        'message' => 'Not Found'
    );
    header('HTTP/ 404');
    header('Content-Type: application/json');
    echo json_encode($response);
}