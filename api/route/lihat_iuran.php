<?php

/**
 * Untuk melihat daftar iuran
 * 
 * @return json
 */
function lihat_iuran()
{
    global $koneksi;
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nik = $_POST['nik'];
        $filter = $_POST['filter'];
        $esc_nik = mysqli_real_escape_string($koneksi, $nik);
        $esc_filter = mysqli_real_escape_string($koneksi, $filter);
        /*
        Jenis status : 0 - Unpaid, 1 - Paid
        */
        // Unpaid
        if ($esc_filter == 0) {
            $data = $koneksi->prepare("SELECT nik, id_tagihan, 
        id_rt, id_rw, jenis_tagihan, total_tagihan, jatuh_tempo, status_pembayaran, 
        rekening, bukti_pembayaran, tanggal_pembayaran FROM tagihan WHERE nik = ? AND status_pembayaran = ?");
            $laporan_mas = 'Pembayaran Tagihan';
            $unpaid = 'Unpaid';
            $data->bind_param('ss', $esc_nik, $unpaid);
            $data->execute();
            $data_res = $data->get_result();
            if ($data_res->num_rows > 0) {
                while ($identitas = $data_res->fetch_array()) {
                    $respond[] = array(
                        'nik' => $identitas['nik'],
                        'id_tagihan' => $identitas['id_tagihan'],
                        'id_rt' => $identitas['id_rt'],
                        'id_rw' => $identitas['id_rw'],
                        'jenis_tagihan' => $identitas['jenis_tagihan'],
                        'total_tagihan' => $identitas['total_tagihan'],
                        'jatuh_tempo' => $identitas['jatuh_tempo'],
                        'status_pembayaran' => $identitas['status_pembayaran'],
                        'rekening' => $identitas['rekening'],
                        'bukti_pembayaran' => $identitas['bukti_pembayaran'],
                        'tanggal_pembayaran' => $identitas['tanggal_pembayaran']
                    );
                }
                $response = generate_response(1, 'Sukses', $respond);
                header('Content-Type: application/json');
                header("HTTP/ 200");
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
        // Paid
        else if ($esc_filter == 1) {
            $data = $koneksi->prepare("SELECT nik, id_tagihan, 
        id_rt, id_rw, jenis_tagihan, total_tagihan, jatuh_tempo, status_pembayaran, 
        rekening, bukti_pembayaran, tanggal_pembayaran FROM tagihan WHERE nik = ? AND status_pembayaran = ?");
            $laporan_mas = 'Pembayaran Tagihan';
            $paid = 'Paid';
            $data->bind_param('ss', $esc_nik, $paid);
            $data->execute();
            $data_res = $data->get_result();
            if ($data_res->num_rows > 0) {
                while ($identitas = $data_res->fetch_array()) {
                    $respond[] = array(
                        'nik' => $identitas['nik'],
                        'id_tagihan' => $identitas['id_tagihan'],
                        'id_rt' => $identitas['id_rt'],
                        'id_rw' => $identitas['id_rw'],
                        'jenis_tagihan' => $identitas['jenis_tagihan'],
                        'total_tagihan' => $identitas['total_tagihan'],
                        'jatuh_tempo' => $identitas['jatuh_tempo'],
                        'status_pembayaran' => $identitas['status_pembayaran'],
                        'rekening' => $identitas['rekening'],
                        'bukti_pembayaran' => 'https://o-semar.com/admin/iuran/berkas/' . $identitas['bukti_pembayaran'],
                        'tanggal_pembayaran' => $identitas['tanggal_pembayaran']
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
