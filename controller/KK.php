<?php

class KK extends Controller {

    // TODO: Controller for Web
    public static function get()
    {
    }

    public static function api_get() 
    {
        $kk = self::sanitize($_GET['kk']);

        return self::get_penduduk_by_kk($kk);
    }

    private static function get_penduduk_by_kk(string $kk)
    {
        $response = array();

        $stmt = self::$mysqli->prepare(
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
            return self::error($stmt->error);
        }

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object())
                array_push($response, $obj);

            return self::response(true, $response);
        } else
            return self::response(false, 'Data tidak ditemukan');

    }
}