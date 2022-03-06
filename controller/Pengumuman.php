<?php

class Pengumuman extends Controller {
    // TODO: Controller for Web
    public static function get() {}

    public static function api_get() {
        // Prevent XSS and Escape Special Chars
        $rt = self::sanitize($_GET['id_rt']);
        $rw = self::sanitize($_GET['id_rw']);

        return self::get_pengumuman($rt, $rw);
    }

    private static function get_pengumuman(string $rt, string $rw) {
        $response = array();

        $stmt = self::$mysqli->prepare(
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
            return self::error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object())
                array_push($response, $obj);
            
            return self::response(true, $response);
        } else
            return self::response(false, 'Data tidak ditemukan');
    }
}