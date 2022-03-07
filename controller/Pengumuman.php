<?php

require_once "controller.php";

class Pengumuman extends Controller {
    // TODO: Controller for Web
    public function get() {}

    public function api_get() {
        // Prevent XSS and Escape Special Chars
        $rt = $this->sanitize($_GET['id_rt']);
        $rw = $this->sanitize($_GET['id_rw']);

        return $this->get_pengumuman($rt, $rw);
    }

    private function get_pengumuman(string $rt, string $rw) {
        $response = array();

        $stmt = $this->mysqli->prepare(
            "SELECT 
                * 
            FROM
                pengumuman
            WHERE 
                id_rt = ? AND
                id_rw = ?"
        );
        $stmt->bind_param('ss', $rt, $rw);
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