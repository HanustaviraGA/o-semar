<?php

/**
 * Untuk melihat daftar laporan
 * 
 * @return json
 */
function lihat_daftar_laporan()
{
    global $koneksi;
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nik = $_POST['nik'];
        $esc_nik = mysqli_real_escape_string($koneksi, $nik);
        $sql = "SELECT * FROM pelaporan WHERE nik = ?";
        $data = query($koneksi, $sql, 's', [$esc_nik]);
        if ($data) {
            $data = $koneksi->prepare("SELECT nik, id_pelaporan, 
        id_rt, id_rw, kategori, keterangan, tanggal_pelaporan, status, 
        alasan FROM pelaporan WHERE nik = ?");
            $data->bind_param('s', $esc_nik);
            $data->execute();
            $data_res = $data->get_result();
            if ($data_res->num_rows > 0) {
                while ($identitas = $data_res->fetch_array()) {
                    $respond[] = array(
                        'nik' => $identitas['nik'],
                        'id_rt' => $identitas['id_rt'],
                        'id_rw' => $identitas['id_rw'],
                        'kategori' => $identitas['kategori'],
                        'keterangan' => $identitas['keterangan'],
                        'tanggal_pelaporan' => $identitas['tanggal_pelaporan'],
                        'status' => $identitas['status'],
                        'alasan' => $identitas['alasan'],
                        'id_pelaporan' => $identitas['id_pelaporan']
                    );
                }
                $response = generate_response(1, 'Sukses', $respond);
                header("HTTP/ 200");
                header('Content-Type: application/json');
                echo json_encode($response);
                exit();
            } else {
                $response = generate_response(0, 'Tidak ada Data');
                header("HTTP/ 500");
                header('Content-Type: application/json');
                echo json_encode($response);
                exit();
            }
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
