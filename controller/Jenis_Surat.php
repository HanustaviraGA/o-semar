<?php

require_once "controller.php";

class JenisSurat extends Controller
{
    // TODO: Controller for Web
    public function get()
    {
    }

    public function api_get()
    {
        return $this->get_jenis_surat();
    }

    private function get_jenis_surat(string $identifier = '1')
    {
        $response = array();

        $stmt = $this->mysqli->prepare(
            "SELECT 
                jenis, 
                keterangan_jenis 
            FROM 
                jenis_surat 
            WHERE 
                identifier = ?"
        );
        $stmt->bind_param('s', $identifier);
        $stmt->execute();

        if ($stmt->errno !== 0)
            return $this->error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0)
            while ($obj = $result->fetch_object())
                array_push($response, $obj);
        else
            return $this->response(false, 'Tidak ada data surat terdaftar');

        return $this->response(true, $response);
    }
}
