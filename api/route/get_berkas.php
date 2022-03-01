<?php

/**
 * Untuk mendapatkan berkas by jenis dan nama berkas
 * 
 * Hanya menerima file dengan ekstensi berikut:
 * - pdf
 * - doc
 * - docx
 * - jpg
 * - jpeg
 * - png
 * - gif
 * 
 * @return file|json
 */
function get_berkas() {
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $jenis_berkas = $_GET["jenis_berkas"];
        $nama_berkas = $_GET["nama_berkas"];
        $basepath = "http://localhost/o-semar";

        $filename = "$basepath/admin/berkas/$jenis_berkas/$nama_berkas";
        // Read laporan file in byte
        $file = fopen($filename, "rb");
        $file_data = "";
        while (!feof($file)) {
            $file_data .= fgetc($file);
        }
        fclose($file);
        
        if (in_array(pathinfo($filename, PATHINFO_EXTENSION), array("jpg", "png", "jpeg"))) {
            header("Content-Type: image/" . pathinfo($filename, PATHINFO_EXTENSION));
        } else if (pathinfo($filename, PATHINFO_EXTENSION) === "pdf") {
            header("Content-Type: application/" . pathinfo($filename, PATHINFO_EXTENSION));
        } else if (in_array(pathinfo($filename, PATHINFO_EXTENSION), array("docx", "doc"))) {
            switch (pathinfo($filename, PATHINFO_EXTENSION)) {
                case "doc":
                    header("Content-Type: application/msword");
                case "docx":
                    header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
            }
        }
        header("HTTP/ 200");
        echo $file_data;
        exit();
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