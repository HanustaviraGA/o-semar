<?php

require_once "controller.php";

class KK extends Controller {

    // TODO: Controller for Web
    public function get()
    {
    }

    public function api_get() 
    {
        $kk = $this->sanitize($_GET['kk']);

        return $this->get_penduduk_by_kk($kk);
    }

    private function get_penduduk_by_kk(string $kk)
    {
        $response = array();

        $stmt = $this->mysqli->prepare(
            "SELECT 
                * 
            FROM 
                penduduk 
            WHERE 
                no_kk = ?"
        );
        $stmt->bind_param('s', $kk);
        $stmt->execute();

        if ($stmt->errno !== 0) {
            return $this->error($stmt->error);
        }

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object())
                array_push($response, $obj);

            return $this->response(true, $response);
        } else
            return $this->response(false, 'Data tidak ditemukan');

    }
}