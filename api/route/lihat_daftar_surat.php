<?php

/**
 * Untuk melihat daftar surat yang ada
 * 
 * @return json
 */
function lihat_daftar_surat()
{
    global $koneksi;
    $nik = $_POST['nik'];
    $esc_nik = mysqli_real_escape_string($koneksi, $nik);

    // Munculkan daftar suratnya
    $sql = "SELECT * FROM suratketerangan WHERE nik = ?";
    $data = query($koneksi, $sql, 's', [$esc_nik]);
    if ($data) {
        $data = $koneksi->prepare("SELECT suratketerangan.nik, suratketerangan.no_surat, 
        id_rt, id_rw, jenis, keperluan, tanggal_pengajuan, keterangan, status, 
        alasan, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran 
        FROM suratketerangan INNER JOIN lampiran ON lampiran.kode = suratketerangan.no_surat  
        WHERE suratketerangan.nik = ? AND jenis_lampiran = ?");
        $pengajuan = 'Pengajuan Surat';
        $data->bind_param('ss', $esc_nik, $pengajuan);
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
                    'alasan' => $identitas['alasan'],
                    'lampiran' => 'https://o-semar.com/admin/surat/berkas/' . $identitas['lampiran'],
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
