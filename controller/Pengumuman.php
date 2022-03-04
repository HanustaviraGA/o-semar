<?php

class Pengumuman extends Controller {
    // TODO: Controller for Web
    public static function get() {}

    public static function api_get() {
        // Prevent XSS and Escape Special Chars
        $rt = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_GET['id_rt'], ENT_COMPAT)
        );
        $rw = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_GET['id_rw'], ENT_COMPAT)
        );

        return self::get_pengumuman($rt, $rw);
    }

    private static function get_pengumuman(string $rt, string $rw) {
        $response = array();

        $stmt = self::$mysqli->prepare("SELECT * FROM pengumuman WHERE id_rt = ? AND id_rw = ?");
        $stmt->bind_param('ss', $rt, $rw);
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