<?php

/**
 * Untuk Logout
 * 
 * @return json
 */
function logout()
{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $filter = $_POST['filter'];
        unset($_SESSION['keadaan']);
        session_unset();
        session_destroy();
        if ($filter == 1) {
            header("location:../admin/views/login.php?pesan=Anda telah berhasil logout");
        } else if ($filter == 0) {
            $response = generate_response(1, 'Sukses');
            header("HTTP/ 200");
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }
    } else {
        header("HTTP/ 405");
        header("Content-Type: application/json");
        echo json_encode(array(
            "status" => 405,
            "msg" => "Method Not Allowed"
        ));
        exit();
    }
}
