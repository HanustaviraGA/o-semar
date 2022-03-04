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
        $nik = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_GET['nik'], ENT_COMPAT)
        );
        
        $pelaporan = self::get_pelaporan($nik);
        return (object) array(
            'status' => true,
            $pelaporan
        );
    }

    public static function api_post() {
        // Prevent XSS and Escape Special Chars
        $nik = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['nik'])
        );
        $rt = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['id_rt'])
        );
        $rw = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['id_rw'])
        );
        $kategori = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['kategori'])
        );
        $keterangan = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['keterangan'])
        );
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
            return (object) array(
                'status' => false,
                'msg' => 'Data tidak boleh kosong'
            );
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

        return (object) array(
            'status' => true,
            'msg' => 'Sukses'
        );
    }

    private static function get_pelaporan(string $nik) {
        $response = array();
        $stmt = self::$mysqli->prepare("SELECT * FROM pelaporan WHERE nik = ?");
        $stmt->bind_param('s', $nik);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($obj = $result->fetch_object()) {
            array_push($response, $obj);
        }
        return $response;
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
                return (object) array(
                    'status' => false,
                    'error' => 'Ekstensi file tidak dapat diterima'
                );
            }
        }
        // Insert entry to database
        $stmt = self::$mysqli->prepare("INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran) 
        VALUES(?, ?, ?, 'Laporan Masyarakat', ?, 'Pending', '-')");
        $stmt->bind_param('ssss', $nik, $uniqid, $new_filename, $tanggal);
        $stmt->execute();

        if ($stmt->errno !== 0)
            return (object) array(
                'status' => true,
                'error' => $stmt->error
            );
        else
            return (object) array(
                'status' => true,
                'msg' => 'Sukses'
            );
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
        $stmt = self::$mysqli->prepare("INSERT INTO pelaporan(id_pelaporan, nik, id_rt, id_rw, kategori, keterangan, tanggal_pelaporan, status, alasan)
        VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending', '-')");
        $stmt->bind_param('sssssss', $uniqid, $nik, $rt, $rw, $kategori, $keterangan, $tanggal);
        $stmt->execute();

        if ($stmt->errno !== 0)
            return (object) array(
                'status' => true,
                'error' => $stmt->error
            );
        else
            return (object) array(
                'status' => true,
                'msg' => 'Sukses'
            );
    }
}