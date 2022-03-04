<?php

class JenisSurat extends Controller
{
    // TODO: Controller for Web
    public static function get()
    {
    }

    public static function api_get()
    {
        $response = $jenis_surat = self::get_jenis_surat();
        if (!$response)
            return (object) array(
                'status' => false,
                'error' => 'Tidak ada data'
            );

        return (object) array(
            'status' => true,
            $response
        );
    }

    private static function get_jenis_surat(string $identifier = '1')
    {
        $response = array();

        $stmt = self::$mysqli->prepare("SELECT jenis, keterangan_jenis FROM jenis_surat WHERE identifier = ?");
        $stmt->bind_param('s', $identifier);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0)
            while ($obj = $result->fetch_object())
                array_push($response, $obj);
        else
            return false;

        return $response;
    }
}
