<?php
    include "../../koneksi.php";
    session_start();

    $data = $_REQUEST;

    switch($data['aksi']){
        case 'bukti' :
            $id = $data['id'];
            $file = $data['file'];
    }
?>