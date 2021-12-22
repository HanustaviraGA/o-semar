<?php

/**
 * Untuk mendapatkan daftar laporan by id pelaporan
 * 
 * @return json
 */
function lihat_daftar_laporan_by_id()
{
    global $koneksi;
    if (isset($_POST)) {
        $id_pelaporan = mysqli_real_escape_string($koneksi, $_POST['id_pelaporan']);
        try {
            $data = query(
                $koneksi,
                "SELECT pelaporan.id_pelaporan, lampiran, jenis_lampiran, status_lampiran, ket_lampiran
            FROM pelaporan INNER JOIN lampiran ON lampiran.kode = pelaporan.id_pelaporan
            WHERE pelaporan.id_pelaporan = ? AND jenis_lampiran = ?",
                "ss",
                [$id_pelaporan, "Laporan Masyarakat"]
            );
            if (count($data) > 0 || $data != null) {
                $basepath = "http://localhost/o-semar/";
                $response = array();
                foreach ($data as $val) {
                    $filename = $basepath . "admin/berkas/laporan/" . $val["lampiran"];

                    $file = fopen($filename, "rb");
                    $file_data = "";
                    while (!feof($file)) {
                        $file_data .= fgetc($file);
                    }
                    fclose($file);
                    
                    $response += array(
                        "id_pelaporan" => $val["id_pelaporan"],
                        "nama_lampiran" => $val["lampiran"],
                        "ekstensi_lampiran" => pathinfo(urlencode($filename), PATHINFO_EXTENSION),
                        "data_lampiran" => base64_encode($file_data)
                    );
                }
                $result = array(
                    "status" => 200,
                    "data" => $response
                );
                header("Content-Type: application/json");
                echo json_encode($result);
                exit();
            } else {
                header("Content-Type: application/json");
                echo json_encode(array(
                    "status" => 200,
                    "msg" => "No data available"
                ));
                exit();
            }
        } catch (ErrorException $err) {
            header("HTTP/ 500");
            header("Content-Type: application/json");
            echo json_encode(array(
                "status" => 500,
                "msg" => "query() -> ErrorException, Contact \"Rafli\" for further information",
                "err" => $err
            ));
            exit();
        }
    } else {
        header("HTTP/ 405");
        exit();
    }
}
