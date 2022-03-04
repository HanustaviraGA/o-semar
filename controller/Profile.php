<?php

class Profile extends Controller
{
    // TODO: Controller for Web
    public static function post()
    {
    }

    public static function api_post()
    {
        $nik = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['nik'])
        );
        $nik_baru = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['nik_baru'])
        );
        $kk = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['kk'])
        );
        $email = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['email'])
        );
        $username = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['username'])
        );
        $password = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['password'])
        );
        

        $penduduk = self::get_user($nik);
        if (count($penduduk) > 0) {
            if (!empty($password)) {
                // Update Password
                $response = self::update_password($nik, $password);
            } else {
                // Update Profile
                $response = self::update_profile(
                    $nik,
                    $nik_baru,
                    $kk,
                    $email,
                    $username
                );
            }
            return $response;
        } else {
            return (object) array(
                'status' => false,
                'error' => 'Data tidak ditemukan'
            );
        }
    }

    private static function get_user(string $nik)
    {
        $response = array();

        $stmt = self::$mysqli->prepare("SELECT * FROM penduduk WHERE nik = ?");
        $stmt->bind_param('s', $nik);
        $stmt->execute();

        if ($stmt->errno !== 0) 
            return (object) array(
                'status' => false,
                'error' => $stmt->error
            );
        
        $result = $stmt->get_result();
        while ($obj = $result->fetch_object())
            array_push($response, $obj);

        return (object) array(
            'status' => true,
            'data' => $response
        );
    }

    private static function update_profile(
        string $nik,
        string $nik_baru,
        string $kk,
        string $email,
        string $username
    ) {
        $stmt = self::$mysqli->prepare("UPDATE penduduk SET no_kk = ?, nik = ?, email = ?, username = ? WHERE nik = ?");
        $stmt->bind_param('sssss', $kk, $nik_baru, $email, $username, $nik);
        $stmt->execute();

        if ($stmt->errno !== 0) 
            return (object) array(
                'status' => false,
                'error' => $stmt->error
            );

        return (object) array(
            'status' => true,
            'data' => 'Update sukses'
        );
    }

    private static function update_password(
        string $nik,
        string $password
    ) {
        $stmt = self::$mysqli->prepare("UPDATE penduduk SET password = ? WHERE nik = ?");
        $stmt->bind_param('s', password_hash($password, PASSWORD_DEFAULT), $nik);
        $stmt->execute();

        if ($stmt->errno !== 0) 
            return (object) array(
                'status' => false,
                'error' => $stmt->error
            );

        return (object) array(
            'status' => true,
            'data' => 'Update sukses'
        );
    }
}
