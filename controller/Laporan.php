<?php

class Laporan extends Controller {

    // TODO: Controller for Web
    public static function get()
    {
    }

    // TODO: Controller for Web
    public static function post()
    {
    }

    public static function api_get() {
        // Prevent XSS and Escape Special Chars
        $nik = self::sanitize($_GET['nik']);
        
        $pelaporan = self::get_pelaporan($nik);
        return $pelaporan;
    }

    public static function api_post() {
        // Prevent XSS and Escape Special Chars
        $nik = self::sanitize($_POST['nik']);
        $rt = self::sanitize($_POST['id_rt']);
        $rw = self::sanitize($_POST['id_rw']);
        $kategori = self::sanitize($_POST['kategori']);
        $keterangan = self::sanitize($_POST['keterangan']);
        $tanggal = date('Y-m-d');
        $prefix = 'LPR';
        $uniqid = uniqid($prefix);
        $file = $_FILES['files'];

        if (
            empty($nik) ||
            empty($rt) ||
            empty($rw) ||
            empty($kategori) ||
            empty($keterangan)
        ) {
            return self::response(false, 'Data tidak boleh kosong');
        }

        if (isset($file) && !empty($file['name'])) {
            $response = self::insert_lampiran($file, $nik, $uniqid, $tanggal);
            if (!$response->status) 
                return $response;
        }
        
        $response = self::insert_pelaporan(
            $uniqid,
            $nik,
            $rt,
            $rw,
            $kategori,
            $keterangan,
            $tanggal
        );
        if (!$response->status)
            return $response;

        return self::response(true, 'Sukses memasukkan laporan');
    }

    private static function get_pelaporan(string $nik) {
        $response = array();
        $stmt = self::$mysqli->prepare(
            "SELECT 
                * 
            FROM 
                pelaporan 
            WHERE 
                nik = ?"
        );
        $stmt->bind_param('s', $nik);
        $stmt->execute();

        if ($stmt->errno !== 0)
            return self::error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object()) {
                array_push($response, $obj);
            }
    
            return self::response(true, $response);
        } else
            return self::response(false, 'Data tidak ditemukan');
    }

    private static function insert_lampiran(
        $file, 
        string $nik, 
        string $uniqid, 
        string $tanggal
    ) {
        // Move uploaded file to server
        foreach ($file['tmp_name'] as $key) {
            $file_tmp = $file['tmp_name'][$key];
            $file_ext = strtolower(pathinfo($file['name'][$key], PATHINFO_EXTENSION));
            // Check file extension
            if (in_array($file_ext, array('jpg', 'jpeg', 'png', 'gif', 'bmp'))) {
                $new_filename = $uniqid .  '_' . $nik . '.' . $file_ext;
                move_uploaded_file($file_tmp, '../admin/laporan/berkas/' . $new_filename);
            } else {
                return self::error('Ekstensi file tidak dapat diterima');
            }
        }
        // Insert entry to database
        $stmt = self::$mysqli->prepare(
            "INSERT INTO lampiran
                (
                    nik, 
                    kode, 
                    lampiran, 
                    jenis_lampiran, 
                    tanggal_lampiran, 
                    status_lampiran, 
                    ket_lampiran
                ) 
            VALUES
                (
                    ?, 
                    ?, 
                    ?, 
                    'Laporan Masyarakat', 
                    ?, 
                    'Pending', 
                    '-')"
        );
        $stmt->bind_param('ssss', $nik, $uniqid, $new_filename, $tanggal);
        $stmt->execute();

        if ($stmt->errno !== 0)
            return self::error($stmt->error);
        else
            return self::response(true, 'Sukses memasukkan lampiran');
    }

    private static function insert_pelaporan(
        string $uniqid,
        string $nik,
        string $rt,
        string $rw,
        string $kategori,
        string $keterangan,
        string $tanggal
    ) {
        // Insert entry to database
        $stmt = self::$mysqli->prepare(
            "INSERT INTO pelaporan
                (
                    id_pelaporan, 
                    nik, 
                    id_rt, 
                    id_rw, 
                    kategori, 
                    keterangan, 
                    tanggal_pelaporan, 
                    status, 
                    alasan
                )
            VALUES 
                (
                    ?, 
                    ?, 
                    ?, 
                    ?, 
                    ?, 
                    ?, 
                    ?, 
                    'Pending', 
                    '-')"
        );
        $stmt->bind_param('sssssss', $uniqid, $nik, $rt, $rw, $kategori, $keterangan, $tanggal);
        $stmt->execute();

        if ($stmt->errno !== 0)
            return self::error($stmt->error);
        else
            return self::response(true, 'Sukses memasukkan pelaporan');
    }
}