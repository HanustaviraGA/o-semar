<?php

/**
 * Untuk melihat daftar surat yang ada
 * 
 * @return json
 */
function lihat_daftar_surat()
{
    global $koneksi;
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nik = $_POST['nik'];
        $esc_nik = mysqli_real_escape_string($koneksi, $nik);

        // Munculkan daftar suratnya
        $sql = "SELECT * FROM suratketerangan WHERE nik = ?";
        $data = query($koneksi, $sql, 's', [$esc_nik]);
        if ($data) {
            $data = $koneksi->prepare("SELECT nik, no_surat, 
        id_rt, id_rw, jenis, keperluan, tanggal_pengajuan, keterangan, status, 
        alasan FROM suratketerangan WHERE nik = ?");
            $data->bind_param('s', $esc_nik);
            $data->execute();
            $data_res = $data->get_result();
            if ($data_res->num_rows > 0) {
                while ($identitas = $data_res->fetch_array()) {
                    $respond[] = array(
                        'nik' => $identitas['nik'],
                        'no_surat' => $identitas['no_surat'],
                        'id_rt' => $identitas['id_rt'],
                        'id_rw' => $identitas['id_rw'],
                        'jenis' => $identitas['jenis'],
                        'keperluan' => $identitas['keperluan'],
                        'tanggal_pengajuan' => $identitas['tanggal_pengajuan'],
                        'keterangan' => $identitas['keterangan'],
                        'status' => $identitas['status'],
                        'alasan' => $identitas['alasan']
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
        } else {
            $response = generate_response(0, 'Tidak ada Data');
            header("HTTP/ 500");
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
