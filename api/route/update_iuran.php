<?php

    /**
 * Untuk update status iuran
 * 
 * @return json
 */
function update_iuran()
{
    global $koneksi;
    $nik = $_POST['nik'];
    $id_tagihan = $_POST['id_tagihan'];
    $tanggal = date("Y-m-d");
    // Escape
    $esc_nik = mysqli_real_escape_string($koneksi, $nik);
    $esc_id = mysqli_real_escape_string($koneksi, $id_tagihan);
    // Cek keberadaan data
    $sql = "SELECT * FROM tagihan WHERE nik = ? AND id_tagihan = ?";
    $data = query($koneksi, $sql, 'ss', [$esc_nik, $esc_id]);
    if ($data) {
        // Masukkan tabel di DB
        if (isset($_FILES["files"]) && !empty($_FILES["files"]["name"])) {
            foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
                $file_name = $key . $_FILES['files']['name'][$key];
                $file_size = $_FILES['files']['size'][$key];
                $file_tmp = $_FILES['files']['tmp_name'][$key];
                $file_type = $_FILES['files']['type'][$key];

                $original_filename = $_FILES['files']['name'][$key];
                $ext = strtolower(pathinfo($_FILES["files"]["name"][$key], PATHINFO_EXTENSION));
                // check extension and upload
                if (in_array($ext, array('jpg', 'jpeg', 'png', 'gif', 'bmp'))) {
                    $filename_without_ext = basename($original_filename, '.' . $ext);
                    $new_filename = uniqid() .  '_' . $nik . '.' . $ext;
                    move_uploaded_file($file_tmp, '../admin/iuran/berkas/' . $new_filename);
                    // Unsecure Code - Masuk Lampiran
                    // $sql = "INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran) 
                    // VALUES('$nik', '$uniqid', '$new_filename', 'Laporan Masyarakat', '$tanggal', 'Pending', '-')";
                    // $query = mysqli_query($koneksi, $sql);

                    // Masuk Lampiran
                    $sql = "INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran) 
                    VALUES(?, ?, ?, 'Pembayaran Tagihan', ?, 'Unpaid', '-')";
                    $query = query($koneksi, $sql, 'ssss', [$nik, $id_tagihan, $new_filename, $tanggal]);
                    // Unsecure Code - Masuk Pelaporan
                    // $sql_pelaporan = "INSERT INTO pelaporan(id_pelaporan, nik, id_rt, id_rw, kategori, keterangan, tanggal_pelaporan, status)
                    // VALUES ('$uniqid', '$nik', '$rt', '$rw', '$kategori', '$keterangan', '$tanggal', 'Pending')";
                    // $query_pelaporan = mysqli_query($koneksi, $sql_pelaporan);

                    $sql_upd = "UPDATE tagihan SET status_pembayaran = ?, bukti_pembayaran = ? WHERE id_tagihan = ?";
                    $data = query($koneksi, $sql_upd, 'sss', ['Unpaid', $new_filename, $esc_id]);
                    $response = generate_response(1, 'Sukses');
                } else {
                    $response = generate_response(2, 'Ekstensi file tidak dapat diterima');
                }
            }
        } else {
            // Unsecure Code - Masuk Surat Keterangan
            // $sql_pelaporan = "INSERT INTO pelaporan(id_pelaporan, nik, id_rt, id_rw, kategori, keterangan, tanggal_pelaporan, status)
            // VALUES ('$uniqid', '$nik', '$rt', '$rw', '$kategori', '$keterangan', '$tanggal', 'Pending')";
            // $query_pelaporan = mysqli_query($koneksi, $sql_pelaporan);

            // Masuk Surat Keterangan
            $sql_upd = "UPDATE tagihan SET status_pembayaran = ? WHERE id_tagihan = ?";
            $data = query($koneksi, $sql_upd, 'ss', ['Lunas', $esc_id]);
            if ($data) {
                $response = generate_response(1, 'Sukses');
            } else {
                $response = generate_response(0, 'Gagal');
            }
        }
    } else {
        $response = generate_response(0, 'Tidak ada Data');
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
