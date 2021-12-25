<?php

/**
 * Untuk melihat daftar laporan
 * 
 * @return json
 */
function lihat_daftar_laporan()
{
    global $koneksi;
    $nik = $_POST['nik'];
    $esc_nik = mysqli_real_escape_string($koneksi, $nik);
    $sql = "SELECT * FROM pelaporan WHERE nik = ?";
    $data = query($koneksi, $sql, 's', [$esc_nik]);
    if ($data) {
        $data = $koneksi->prepare("SELECT pelaporan.nik, pelaporan.id_pelaporan, 
        id_rt, id_rw, kategori, keterangan, tanggal_pelaporan, status, 
        alasan, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran 
        FROM pelaporan INNER JOIN lampiran ON lampiran.kode = pelaporan.id_pelaporan  
        WHERE pelaporan.nik = ? AND jenis_lampiran = ?");
        $laporan_mas = 'Laporan Masyarakat';
        $data->bind_param('ss', $esc_nik, $laporan_mas);
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
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            $response = generate_response(0, 'Tidak ada Data');
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
}
