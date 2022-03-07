<?php

require_once "controller.php";

class Surat extends Controller
{
    // TODO: Controller for Web
    public function get()
    {
    }
    
    // TODO: Controller for Web
    public function post()
    {
    }

    public function api_get()
    {
        // Prevent XSS and Escape Special Chars
        $nik = $this->sanitize($_GET['nik']);

        $response = $this->get_list_of_surat($nik);
        // Return Error or No Data
        if (!$response->status) {
            return $response;
        }

        return $response;
    }

    public function api_post()
    {
        // Prevent XSS and Escape Special Chars
        $jenis = $this->sanitize($_POST['jenis']);
        $nik = $this->sanitize($_POST['nik']);
        $rt = $this->sanitize($_POST['id_rt']);
        $rw = $this->sanitize($_POST['id_rw']);
        $keterangan = $this->sanitize($_POST['keterangan']);
        $keperluan = $this->sanitize($_POST['keperluan']);

        $tanggal = date('Y-m-d');
        $prefix = 'SRT';
        $uniqid = uniqid($prefix);
        $file = $_FILES['files'];

        if (isset($file) && !empty($file['name'])) {
            $response = $this->insert_lampiran($file, $uniqid, $nik, $tanggal);
            // Return Error or No Data
            if (!$response->status)
                return $response;
        }
        $response = $this->insert_surat_keterangan(
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

        return $this->response(true, 'Insert surat sukses!');
    }

    private function get_list_of_surat(string $nik)
    {
        $response = array();

        $stmt = $this->mysqli->prepare(
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
            return $this->error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows === 0)
            return $this->response(false, 'Tidak ada data surat untuk nik tersebut');
        
        return $this->response(true, (object) $response);
    }

    private function insert_lampiran(
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
                return $this->error('Ekstensi file tidak dapat diterima');
            }
        }
        // Insert entry to database
        $stmt = $this->mysqli->prepare(
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
            return $this->error($stmt->error);

        return $this->response(true, 'Sukses');
    }

    private function insert_surat_keterangan(
        string $uniqid,
        string $nik,
        string $rt,
        string $rw,
        string $jenis,
        string $keperluan,
        string $tanggal,
        string $keterangan
    ) {
        $stmt = $this->mysqli->prepare(
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
            return $this->error($stmt->error);
        else
            return $this->response(true, 'Sukses');
    }
}
