<?php


/**
 * Untuk membuat laporan
 * 
 * @return json
 */
function buat_laporan()
{
    global $koneksi;
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Ambil data form
        $nik = $_POST['nik'];
        $rt = $_POST['id_rt'];
        $rw = $_POST['id_rw'];
        $kategori = $_POST['kategori'];
        $keterangan = $_POST['keterangan'];
        $tanggal = date("Y-m-d");
        // Default value
        $prefix = 'LPR';
        $uniqid = uniqid($prefix);
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
                    move_uploaded_file($file_tmp, '../admin/laporan/berkas/' . $new_filename);

                    // Masuk Lampiran
                    $sql = "INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran) 
                VALUES(?, ?, ?, 'Laporan Masyarakat', ?, 'Pending', '-')";
                    $query = query($koneksi, $sql, 'ssss', [$nik, $uniqid, $new_filename, $tanggal]);

                    $sql_pelaporan = "INSERT INTO pelaporan(id_pelaporan, nik, id_rt, id_rw, kategori, keterangan, tanggal_pelaporan, status, alasan)
                VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending', '-')";
                    $query_pelaporan = query($koneksi, $sql_pelaporan, 'sssssss', [$uniqid, $nik, $rt, $rw, $kategori, $keterangan, $tanggal]);

                    $response = generate_response(1, 'Sukses');
                } else {
                    $response = generate_response(2, 'Ekstensi file tidak dapat diterima');
                }
            }
        } else {
            // Masuk Surat Keterangan
            $sql_pelaporan = "INSERT INTO pelaporan(id_pelaporan, nik, id_rt, id_rw, kategori, keterangan, tanggal_pelaporan, status, alasan)
        VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending', '-')";
            $query_pelaporan = query($koneksi, $sql_pelaporan, 'sssssss', [$uniqid, $nik, $rt, $rw, $kategori, $keterangan, $tanggal]);
            if ($query_pelaporan) {
                header("HTTP/ 201");
                $response = generate_response(1, 'Sukses');
            } else {
                header("HTTP/ 500");
                $response = generate_response(0, 'Gagal');
            }
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
