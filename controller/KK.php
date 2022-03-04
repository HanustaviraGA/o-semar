<?php

class KK extends Controller {

    // TODO: Controller for Web
    public static function get()
    {
    }

    public static function api_get() 
    {
        $kk = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_GET['kk'], ENT_COMPAT)
        );

        return self::get_penduduk_by_kk($kk);
    }

    private static function get_penduduk_by_kk(string $kk)
    {
        $response = array();

        $stmt = self::$mysqli->prepare("SELECT * FROM penduduk WHERE no_kk = ?");
        $stmt->bind_param('s', $kk);
        $stmt->execute();

        if ($stmt->errno !== 0) {
            return (object) array(
                'status' => false,
                'error' => $stmt->error
            );
        }

        $result = $stmt->get_result();
        while ($obj = $result->fetch_object())
            array_push($response, $obj);

        return (object) array(
            'status' => true,
            $response
        );
    }
}