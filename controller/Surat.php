<?php

class Surat extends Controller
{
    // TODO: Controller for Web
    public static function get()
    {
    }
    
    // TODO: Controller for Web
    public static function post()
    {
    }

    public static function api_get()
    {
        // Prevent XSS and Escape Special Chars
        $nik = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['nik'])
        );

        $response = self::get_list_of_surat($nik);
        if (!$response) {
            return (object) array(
                'status' => false,
                'error' => 'Tidak ada data'
            );
        }

        return (object) array(
            'status' => true,
            $response
        );
    }

    public static function api_post()
    {
        // Prevent XSS and Escape Special Chars
        $jenis = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['jenis'])
        );
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
        $keterangan = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['keterangan'])
        );
        $keperluan = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['keperluan'])
        );

        $tanggal = date('Y-m-d');
        $prefix = 'SRT';
        $uniqid = uniqid($prefix);
        $file = $_FILES['files'];

        if (isset($file) && !empty($file['name'])) {
            $response = self::insert_lampiran($file, $uniqid, $nik, $tanggal);
            if (!$response->status)
                return $response;
        }
        $response = self::insert_surat_keterangan(
            $uniqid,
            $nik,
            $rt,
            $rw,
            $jenis,
            $keperluan,
            $tanggal,
            $keterangan
        );
        if (!$response->status)
            return $response;

        return (object) array(
            'status' => true,
            'msg' => 'Sukses'
        );
    }

    private static function get_list_of_surat(string $nik)
    {
        $response = array();

        $stmt = self::$mysqli->prepare("SELECT * FROM suratketerangan WHERE nik = ?");
        $stmt->bind_param('s', $nik);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $stmt = self::$mysqli->prepare("SELECT nik, no_surat, 
            id_rt, id_rw, jenis, keperluan, tanggal_pengajuan, keterangan, status, 
            alasan FROM suratketerangan WHERE nik = ?");
            $stmt->bind_param('s', $nik);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($obj = $result->fetch_object())
                    array_push($response, $obj);
            } else {
                return false;
            }
        } else {
            return false;
        }

        return $response;
    }

    private static function insert_lampiran(
        $file,
        string $uniqid,
        string $nik,
        string $tanggal
    ) {
        foreach ($file['tmp_name'] as $key) {
            $file_tmp = $file['tmp_name'][$key];
            $file_ext = strtolower(pathinfo($file['name'][$key], PATHINFO_EXTENSION));
            // Check extension
            if (in_array($file_ext, array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'pdf'))) {
                $new_filename = $uniqid .  '_' . $nik . '.' . $file_ext;
                move_uploaded_file($file_tmp, '../admin/surat/berkas/' . $new_filename);
            } else {
                return (object) array(
                    'status' => false,
                    'error' => 'Ekstensi file tidak dapat diterima'
                );
            }
        }
        // Insert entry to database
        $stmt = self::$mysqli->prepare("INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran) 
        VALUES(?, ?, ?, 'Pengajuan Surat', ?, 'Pending', '-')");
        $stmt->bind_param('ssss', $nik, $uniqid, $new_filename, $tanggal);
        $stmt->execute();

        return (object) array(
            'status' => true,
            'msg' => 'Sukses'
        );
    }

    private static function insert_surat_keterangan(
        string $uniqid,
        string $nik,
        string $rt,
        string $rw,
        string $jenis,
        string $keperluan,
        string $tanggal,
        string $keterangan
    ) {
        $stmt = self::$mysqli->prepare("INSERT INTO suratketerangan(no_surat, nik, id_rt, id_rw, jenis, keperluan, tanggal_pengajuan, keterangan, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending')");
        $stmt->bind_param('ssssssss', $uniqid, $nik, $rt, $rw, $jenis, $keperluan, $tanggal, $keterangan);
        $stmt->execute();

        if ($stmt->errno !== 0)
            return (object) array(
                'status' => false,
                'error' => $stmt->error
            );
        else
            return (object) array(
                'status' => true,
                'msg' => 'Sukses'
            );
    }
}
