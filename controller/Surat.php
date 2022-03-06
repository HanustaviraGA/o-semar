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
        $nik = self::sanitize($_POST['nik']);

        $response = self::get_list_of_surat($nik);
        // Return Error or No Data
        if (!$response->status) {
            return $response;
        }

        return $response;
    }

    public static function api_post()
    {
        // Prevent XSS and Escape Special Chars
        $jenis = self::sanitize($_POST['jenis']);
        $nik = self::sanitize($_POST['nik']);
        $rt = self::sanitize($_POST['id_rt']);
        $rw = self::sanitize($_POST['id_rw']);
        $keterangan = self::sanitize($_POST['keterangan']);
        $keperluan = self::sanitize($_POST['keperluan']);

        $tanggal = date('Y-m-d');
        $prefix = 'SRT';
        $uniqid = uniqid($prefix);
        $file = $_FILES['files'];

        if (isset($file) && !empty($file['name'])) {
            $response = self::insert_lampiran($file, $uniqid, $nik, $tanggal);
            // Return Error or No Data
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
        // Return Error or No Data
        if (!$response->status)
            return $response;

        return self::response(true, 'Insert surat sukses!');
    }

    private static function get_list_of_surat(string $nik)
    {
        $response = array();

        $stmt = self::$mysqli->prepare(
            "SELECT 
                nik, 
                no_surat, 
                id_rt, 
                id_rw, 
                jenis, 
                keperluan, 
                tanggal_pengajuan, 
                keterangan, 
                status, 
                alasan 
            FROM 
                suratketerangan 
            WHERE 
                nik = ?"
        );
        $stmt->bind_param('s', $nik);
        $stmt->execute();

        if ($stmt->errno !== 0)
            return self::error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows === 0)
            return self::response(false, 'Tidak ada data surat untuk nik tersebut');
        
        return self::response(true, (object) $response);
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
                'Pengajuan Surat', 
                ?, 
                'Pending', 
                '-'
            )"
        );
        $stmt->bind_param('ssss', $nik, $uniqid, $new_filename, $tanggal);
        $stmt->execute();

        if ($stmt->errno !== 0)
            return self::error($stmt->error);

        return self::response(true, 'Sukses');
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
        $stmt = self::$mysqli->prepare(
            "INSERT INTO suratketerangan
                (
                    no_surat, 
                    nik, 
                    id_rt, 
                    id_rw, 
                    jenis, 
                    keperluan, 
                    tanggal_pengajuan, 
                    keterangan, 
                    status
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
                    ?, 
                    'Pending'
                )"
        );
        $stmt->bind_param('ssssssss', $uniqid, $nik, $rt, $rw, $jenis, $keperluan, $tanggal, $keterangan);
        $stmt->execute();

        if ($stmt->errno !== 0)
            return self::error($stmt->error);
        else
            return self::response(true, 'Sukses');
    }
}
