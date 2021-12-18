<?php

/**
 * Untuk melihat daftar iuran
 * 
 * @return json
 */
function lihat_iuran()
{
    global $koneksi;
    $nik = $_POST['nik'];
    $filter = $_POST['filter'];
    $esc_nik = mysqli_real_escape_string($koneksi, $nik);
    $esc_filter = mysqli_real_escape_string($koneksi, $filter);
    /*
    Jenis status : 0 - Unpaid, 1 - Paid
    */
    // Unpaid
    if ($esc_filter == 0) {
        $data = $koneksi->prepare("SELECT tagihan.nik, tagihan.id_tagihan, 
        id_rt, id_rw, jenis_tagihan, total_tagihan, jatuh_tempo, status_pembayaran, 
        rekening, bukti_pembayaran, tanggal_pembayaran, lampiran, jenis_lampiran, tanggal_lampiran, 
        status_lampiran, ket_lampiran FROM tagihan INNER JOIN 
        lampiran ON lampiran.kode = tagihan.id_tagihan  
        WHERE tagihan.nik = ? AND jenis_lampiran = ? AND status_lampiran = ?");
        $laporan_mas = 'Pembayaran Tagihan';
        $unpaid = 'Unpaid';
        $data->bind_param('sss', $esc_nik, $laporan_mas, $unpaid);
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
                    'tanggal_pembayaran' => $identitas['tanggal_pembayaran'],
                    'lampiran' => 'https://o-semar.com/admin/iuran/berkas/' . $identitas['lampiran'],
                    'jenis_lampiran' => $identitas['jenis_lampiran'],
                    'tanggal_lampiran' => $identitas['tanggal_lampiran'],
                    'status_lampiran' => $identitas['status_lampiran'],
                    'ket_lampiran' => $identitas['ket_lampiran']
                );
            }
            $response = generate_response(1, 'Sukses', $respond);
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            $response = generate_response(0, 'Tidak ada Data');
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
    // Paid
    else if ($esc_filter == 1) {
        $data = $koneksi->prepare("SELECT tagihan.nik, tagihan.id_tagihan, 
        id_rt, id_rw, jenis_tagihan, total_tagihan, jatuh_tempo, status_pembayaran, 
        rekening, bukti_pembayaran, tanggal_pembayaran, lampiran, jenis_lampiran, tanggal_lampiran, 
        status_lampiran, ket_lampiran FROM tagihan INNER JOIN 
        lampiran ON lampiran.kode = tagihan.id_tagihan  
        WHERE tagihan.nik = ? AND jenis_lampiran = ? AND status_lampiran = ?");
        $laporan_mas = 'Pembayaran Tagihan';
        $unpaid = 'Paid';
        $data->bind_param('sss', $esc_nik, $laporan_mas, $unpaid);
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
                    'tanggal_pembayaran' => $identitas['tanggal_pembayaran'],
                    'lampiran' => 'https://o-semar.com/admin/iuran/berkas/' . $identitas['lampiran'],
                    'jenis_lampiran' => $identitas['jenis_lampiran'],
                    'tanggal_lampiran' => $identitas['tanggal_lampiran'],
                    'status_lampiran' => $identitas['status_lampiran'],
                    'ket_lampiran' => $identitas['ket_lampiran']
                );
            }
            $response = generate_response(1, 'Sukses', $respond);
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            $response = generate_response(0, 'Tidak ada Data');
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
}
