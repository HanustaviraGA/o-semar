<?php

/**
 * Untuk update status iuran
 * 
 * @return json
 */
function update_iuran()
{
    global $koneksi;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

                        // Masuk Lampiran
                        $sql = "INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran) 
                    VALUES(?, ?, ?, 'Pembayaran Tagihan', ?, 'Unpaid', '-')";
                        $query = query($koneksi, $sql, 'ssss', [$nik, $id_tagihan, $new_filename, $tanggal]);

                        $sql_upd = "UPDATE tagihan SET status_pembayaran = ?, bukti_pembayaran = ? WHERE id_tagihan = ?";
                        $data = query($koneksi, $sql_upd, 'sss', ['Unpaid', $new_filename, $esc_id]);
                        $response = generate_response(1, 'Sukses');
                        header("HTTP/ 200");
                    } else {
                        $response = generate_response(2, 'Ekstensi file tidak dapat diterima');
                        header("HTTP/ 500");
                    }
                }
            } else {
                // Masuk Surat Keterangan
                $sql_upd = "UPDATE tagihan SET status_pembayaran = ? WHERE id_tagihan = ?";
                $data = query($koneksi, $sql_upd, 'ss', ['Lunas', $esc_id]);
                if ($data) {
                    $response = generate_response(1, 'Sukses');
                    header("HTTP/ 200");
                } else {
                    $response = generate_response(0, 'Gagal');
                    header("HTTP/ 500");
                }
            }
        } else {
            $response = generate_response(0, 'Tidak ada Data');
            header("HTTP/ 200");
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
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
