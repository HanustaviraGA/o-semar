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
            // Pelaporan
            if($_POST['filter'] == 1){
                $data = query(
                    $koneksi,
                    "SELECT pelaporan.id_pelaporan, lampiran, jenis_lampiran, status_lampiran, ket_lampiran
                FROM pelaporan INNER JOIN lampiran ON lampiran.kode = pelaporan.id_pelaporan
                WHERE pelaporan.id_pelaporan = ? AND jenis_lampiran = ?",
                    "ss",
                    [$id_pelaporan, "Laporan Masyarakat"]
                );
            // Surat
            }else if($_POST['filter'] == 2){
                $data = query(
                    $koneksi,
                    "SELECT suratketerangan.no_surat, lampiran, jenis_lampiran, status_lampiran, ket_lampiran
                FROM suratketerangan INNER JOIN lampiran ON lampiran.kode = suratketerangan.no_surat
                WHERE suratketerangan.no_surat = ? AND jenis_lampiran = ?",
                    "ss",
                    [$id_pelaporan, "Pengajuan Surat"]
                );
            // Pengumuman
            }else if($_POST['filter'] == 3){
                $data = query(
                    $koneksi,
                    "SELECT pengumuman.id, lampiran, jenis_lampiran, status_lampiran, ket_lampiran
                FROM pengumuman INNER JOIN lampiran ON lampiran.kode = pengumuman.id
                WHERE pengumuman.id = ? AND jenis_lampiran = ?",
                    "ss",
                    [$id_pelaporan, "Pengumuman Warga"]
                );
            // Iuran
            }else if($_POST['filter'] == 4){
                $data = query(
                    $koneksi,
                    "SELECT tagihan.id_tagihan, lampiran, jenis_lampiran, status_lampiran, ket_lampiran
                FROM tagihan INNER JOIN lampiran ON lampiran.kode = tagihan.id_tagihan
                WHERE tagihan.id_tagihan = ? AND jenis_lampiran = ?",
                    "ss",
                    [$id_pelaporan, "Pembayaran Tagihan"]
                );
            }
            if (count($data) > 0 || $data != null) {
                $basepath = "http://localhost/o-semar/";
                $response = array();
                foreach ($data as $val) {
                    // Pelaporan
                    if($_POST['filter'] == 1){
                        $filename = $basepath . "admin/berkas/laporan/" . $val["lampiran"];
                    // Surat
                    }else if($_POST['filter'] == 2){
                        $filename = $basepath . "admin/berkas/surat/" . $val["lampiran"];
                    // Pengumuman
                    }else if($_POST['filter'] == 3){
                        $filename = $basepath . "admin/berkas/pengumuman/" . $val["lampiran"];
                    // Iuran
                    }else if($_POST['filter'] == 4){
                        $filename = $basepath . "admin/berkas/iuran/" . $val["lampiran"];
                    }
                    // Read laporan file in byte
                    // $file = fopen($filename, "rb");
                    // $file_data = "";
                    // while (!feof($file)) {
                    //     $file_data .= fgetc($file);
                    // }
                    // fclose($file);
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
                    // Pelaporan
                    if($_POST['filter'] == 1){
                        $response += array(
                            "id_pelaporan" => $val["id_pelaporan"],
                            "nama_lampiran" => $val["lampiran"],
                            "status_lampiran" => $val["status_lampiran"],
                            "ket_lampiran" => $val["ket_lampiran"],
                            "ekstensi_lampiran" => pathinfo(urlencode($filename), PATHINFO_EXTENSION),
                            "data_lampiran" => "http://localhost/o-semar/api/rest.php?function=get_berkas&key=buwinakeren&jenis_berkas=laporan&nama_berkas=" . $val["lampiran"]
                        );
                    // Surat
                    }else if($_POST['filter'] == 2){
                        $response += array(
                            "id_pelaporan" => $val["no_surat"],
                            "nama_lampiran" => $val["lampiran"],
                            "status_lampiran" => $val["status_lampiran"],
                            "ket_lampiran" => $val["ket_lampiran"],
                            "ekstensi_lampiran" => pathinfo(urlencode($filename), PATHINFO_EXTENSION),
                            "data_lampiran" => "http://localhost/o-semar/api/rest.php?function=get_berkas&key=buwinakeren&jenis_berkas=surat&nama_berkas=" . $val["lampiran"]
                        );
                    // Pengumuman
                    }else if($_POST['filter'] == 3){
                        $response += array(
                            "id_pelaporan" => $val["id"],
                            "nama_lampiran" => $val["lampiran"],
                            "status_lampiran" => $val["status_lampiran"],
                            "ket_lampiran" => $val["ket_lampiran"],
                            "ekstensi_lampiran" => pathinfo(urlencode($filename), PATHINFO_EXTENSION),
                            "data_lampiran" => "http://localhost/o-semar/api/rest.php?function=get_berkas&key=buwinakeren&jenis_berkas=pengumuman&nama_berkas=" . $val["lampiran"]
                        );
                    // Iuran
                    }else if($_POST['filter'] == 4){
                        $response += array(
                            "id_pelaporan" => $val["id_tagihan"],
                            "nama_lampiran" => $val["lampiran"],
                            "status_lampiran" => $val["status_lampiran"],
                            "ket_lampiran" => $val["ket_lampiran"],
                            "ekstensi_lampiran" => pathinfo(urlencode($filename), PATHINFO_EXTENSION),
                            "data_lampiran" => "http://localhost/o-semar/api/rest.php?function=get_berkas&key=buwinakeren&jenis_berkas=iuran&nama_berkas=" . $val["lampiran"]
                        );
                    }
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
