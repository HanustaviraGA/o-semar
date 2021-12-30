<?php

/**
 * Untuk membuat surat
 * 
 * @return json
 */
function buat_surat()
{
    global $koneksi;
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Ambil data form
        $jenis = $_POST['jenis'];
        $nik = $_POST['nik'];
        $rt = $_POST['id_rt'];
        $rw = $_POST['id_rw'];
        $tanggal = date("Y-m-d");
        $keterangan = $_POST['keterangan'];
        $keperluan = $_POST['keperluan'];
        // Default value
        $prefix = 'SRT';
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
                if (in_array($ext, array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'pdf'))) {
                    $filename_without_ext = basename($original_filename, '.' . $ext);
                    $new_filename = uniqid() .  '_' . $nik . '.' . $ext;
                    move_uploaded_file($file_tmp, '../admin/surat/berkas/' . $new_filename);
                    // Masuk Lampiran
                    $sql = "INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran) 
                VALUES('$nik', '$uniqid', '$new_filename', 'Pengajuan Surat', '$tanggal', 'Pending', '-')";
                    $query = mysqli_query($koneksi, $sql);

                    // Masuk Surat Keterangan
                    $sql_pelaporan = "INSERT INTO suratketerangan(no_surat, nik, id_rt, id_rw, jenis, keperluan, tanggal_pengajuan, keterangan, status, alasan)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending', '-')";
                    $query_pelaporan = query($koneksi, $sql_pelaporan, 'ssssssss', [$uniqid, $nik, $rt, $rw, $jenis, $keperluan, $tanggal, $keterangan]);
                    $response  = generate_response(1, 'Sukses');
                } else {
                    $response = generate_response(2, 'Ekstensi file tidak dapat diterima');
                }
            }
        } else {
            // Masuk Surat Keterangan
            $sql_pelaporan = "INSERT INTO suratketerangan(no_surat, nik, id_rt, id_rw, jenis, keperluan, tanggal_pengajuan, keterangan, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";
            $query_pelaporan = query($koneksi, $sql_pelaporan, 'ssssssss', [$uniqid, $nik, $rt, $rw, $jenis, $keperluan, $tanggal, $keterangan]);
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
