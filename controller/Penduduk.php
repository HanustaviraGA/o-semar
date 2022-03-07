<?php

require_once "controller.php";

class Penduduk extends Controller
{

    public function get()
    {
    }

    public function api_get()
    {
        // TODO: What is filter value?

        $penduduk = $this->get_penduduk();

        // Return Error or No Data
        if (!$penduduk->status)
            return $penduduk;

        if (count($penduduk->data) > 0)
            return $penduduk;
        else
            return $this->response(false, 'Tidak ada data');
    }

    private function get_penduduk() {
        $response = array();

        $stmt = $this->mysqli->prepare(
            "SELECT 
                no_kk, 
                nik, 
                nama, 
                tempat_lahir, 
                tanggal_lahir, 
                alamat, 
                id_rt, 
                id_rw, 
                jenis_kelamin, 
                agama, 
                status_perkawinan, 
                pekerjaan, 
                gol_darah, 
                kewarganegaraan, 
                status_ktp, 
                foto_ktp, 
                email, 
                username, 
                no_hp, 
                tanggal_reg 
            FROM 
                penduduk"
        );
        $stmt->execute();

        if ($stmt->errno !== 0)
            return $this->error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object())
                array_push($response, $obj);
    
            return $this->response(true, $response);
        } else
            return $this->response(false, 'Data tidak ditemukan');
    }
}
