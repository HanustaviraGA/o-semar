<?php

/**
 * Register controller
 * 
 * @version 2.0.0
 */
class Register extends Controller
{

    // TODO: Controller for Web
    public static function post()
    {
    }

    public static function api_post()
    {
        // Prevent XSS and Escape Special Chars
        $no_kk = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['no_kk'], ENT_COMPAT)
        );
        $nik = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['nik'], ENT_COMPAT)
        );
        $nama = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['nama'], ENT_COMPAT)
        );
        $email = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['email'], ENT_COMPAT)
        );
        $username = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['username'], ENT_COMPAT)
        );
        $password = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['password'], ENT_COMPAT)
        );

        if (
            empty($no_kk) ||
            empty($nik) ||
            empty($nama) ||
            empty($email) ||
            empty($username) ||
            empty($password)
        ) {
            return (object) array(
                'status' => false,
                'msg' => 'Data tidak boleh kosong'
            );
        }

        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        if (!self::check_user_duplicate($no_kk, $nik, $nama, $username)) {
            $response = self::create_new_user(
                $no_kk,
                $nik,
                $nama,
                $email,
                $username,
                $hash_password
            );
            if (!$response->status) {
                return (object) array(
                    'status' => false,
                    'error' => $response->error
                );
            }
            return $response;
        } else {
            return (object) array(
                'status' => false,
                'msg' => 'Terdapat pengguna dengan data yang sama'
            );
        }
    }

    private static function check_user_duplicate(
        string $no_kk,
        string $nik,
        string $nama,
        string $username
    ) {
        $stmt = self::$mysqli->prepare("SELECT * FROM penduduk WHERE no_kk = ? AND nik = ? AND nama = ? AND username = ?");
        $stmt->bind_param('ssss', $no_kk, $nik, $nama, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return false;
        } else {
            return true;
        }
    }

    private static function create_new_user(
        string $no_kk,
        string $nik,
        string $nama,
        string $email,
        string $username,
        string $hashed_password
    ) {
        $stmt = self::$mysqli->prepare("INSERT INTO penduduk SET no_kk = ?, nik = ?, nama = ?, email = ?, username = ?, password = ?");
        $stmt->bind_param('ssssss', $no_kk, $nik, $nama, $email, $username, $hashed_password);
        $stmt->execute();
        if ($stmt->errno === 0) {
            return (object) array(
                'status' => true,
                'msg' => 'Registrasi berhasil'
            );
        } else {
            return (object) array(
                'status' => false,
                'errno' => $stmt->errno,
                'error' => $stmt->error
            );
        }
    }
}
