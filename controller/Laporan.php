<?php

require_once "controller.php";

class Laporan extends Controller {

    // TODO: Controller for Web
    public function get()
    {
    }

    // TODO: Controller for Web
    public function post()
    {
    }

    public function api_get() {
        // Prevent XSS and Escape Special Chars
        $nik = $this->sanitize($_GET['nik']);
        
        $pelaporan = $this->get_pelaporan($nik);
        return $pelaporan;
    }

    public function api_post() {
        // Prevent XSS and Escape Special Chars
        $nik = $this->sanitize($_POST['nik']);
        $rt = $this->sanitize($_POST['id_rt']);
        $rw = $this->sanitize($_POST['id_rw']);
        $kategori = $this->sanitize($_POST['kategori']);
        $keterangan = $this->sanitize($_POST['keterangan']);
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
            return $this->response(false, 'Data tidak boleh kosong');
        }

        if (isset($file) && !empty($file['name'])) {
            $response = $this->insert_lampiran($file, $nik, $uniqid, $tanggal);
            if (!$response->status) 
                return $response;
        }
        
        $response = $this->insert_pelaporan(
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

        return $this->response(true, 'Sukses memasukkan laporan');
    }

    private function get_pelaporan(string $nik) {
        $response = array();
        $stmt = $this->mysqli->prepare(
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
            return $this->error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object()) {
                array_push($response, $obj);
            }
    
            return $this->response(true, $response);
        } else
            return $this->response(false, 'Data tidak ditemukan');
    }

    private function insert_lampiran(
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
                    'Laporan Masyarakat', 
                    ?, 
                    'Pending', 
                    '-')"
        );
        $stmt->bind_param('ssss', $nik, $uniqid, $new_filename, $tanggal);
        $stmt->execute();

        if ($stmt->errno !== 0)
            return $this->error($stmt->error);
        else
            return $this->response(true, 'Sukses memasukkan lampiran');
    }

    private function insert_pelaporan(
        string $uniqid,
        string $nik,
        string $rt,
        string $rw,
        string $kategori,
        string $keterangan,
        string $tanggal
    ) {
        // Insert entry to database
        $stmt = $this->mysqli->prepare(
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
            return $this->error($stmt->error);
        else
            return $this->response(true, 'Sukses memasukkan pelaporan');
    }
}