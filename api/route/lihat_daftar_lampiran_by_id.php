<?php

/**
 * Untuk mendapatkan daftar lampiran by id pelaporan
 * 
 * @return json
 */
function lihat_daftar_lampiran_by_id()
{
    global $koneksi;
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
                    // Read laporan file in byte
                    $file = fopen($filename, "rb");
                    $file_data = "";
                    while (!feof($file)) {
                        $file_data .= fgetc($file);
                    }
                    fclose($file);
                    // Store to response (Conpressed) -> Perbedaannya cuma sedikit
                    // $response += array(
                    //     "id_pelaporan" => $val["id_pelaporan"],
                    //     "nama_lampiran" => $val["lampiran"],
                    //     "ekstensi_lampiran" => pathinfo(urlencode($filename), PATHINFO_EXTENSION),
                    //     "compressed" => true,
                    //     "compression_method" => "gzip",
                    //     "data_lampiran" => base64_encode(gzcompress($file_data, 9))
                    // );
                    // Store to response (Uncompressed)
                    // $response += array(
                    //     "id_pelaporan" => $val["id_pelaporan"],
                    //     "nama_lampiran" => $val["lampiran"],
                    //     "ekstensi_lampiran" => pathinfo(urlencode($filename), PATHINFO_EXTENSION),
                    //     "data_lampiran" => base64_encode($file_data)
                    // );
                    // Store to response (Resource directed to another link)
                    $response += array(
                        "id_pelaporan" => $val["id_pelaporan"],
                        "nama_lampiran" => $val["lampiran"],
                        "ekstensi_lampiran" => pathinfo(urlencode($filename), PATHINFO_EXTENSION),
                        "data_lampiran" => "http://localhost/o-semar/api/rest.php?function=get_berkas&key=buwinakeren&jenis_berkas=laporan&nama_berkas=" . $val["lampiran"]
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
        header("Content-Type: application/json");
        echo json_encode(array(
            "status" => 405,
            "msg" => "Method Not Allowed"
        ));
        exit();
    }
}
