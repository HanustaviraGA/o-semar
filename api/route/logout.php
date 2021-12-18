<?php

/**
 * Untuk Logout
 * 
 * @return json
 */
function logout()
{
    $filter = $_POST['filter'];
    unset($_SESSION['keadaan']);
    session_unset();
    session_destroy();
    if ($filter == 1) {
        header("location:../admin/login.php?pesan=Anda telah berhasil logout");
    } else if ($filter == 0) {
        $response = generate_response(1, 'Sukses');
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
