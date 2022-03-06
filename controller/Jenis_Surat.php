<?php

class JenisSurat extends Controller
{
    // TODO: Controller for Web
    public static function get()
    {
    }

    public static function api_get()
    {
        return self::get_jenis_surat();
    }

    private static function get_jenis_surat(string $identifier = '1')
    {
        $response = array();

        $stmt = self::$mysqli->prepare(
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
            return self::error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0)
            while ($obj = $result->fetch_object())
                array_push($response, $obj);
        else
            return self::response(false, 'Tidak ada data surat terdaftar');

        return self::response(true, $response);
    }
}
