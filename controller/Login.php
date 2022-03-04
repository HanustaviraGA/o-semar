<?php

/**
 * Login Controller
 * 
 * @version 2.0.0
 */
class Login extends Controller
{

    // TODO: Controller for Web
    public static function post()
    {
    }

    public static function api_post()
    {
        // Prevent XSS and Escape Special Chars
        $username = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['username'], ENT_COMPAT)
        );
        $input_password = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_POST['password'], ENT_COMPAT)
        );
        // Check request data
        if (empty($username) || empty($password)) {
            return (object) array(
                'status' => false,
                'msg' => 'Data tidak boleh kosong'
            );
        }
        // 
        $penduduk = self::get_penduduk_by_username($username);
        if (count($penduduk) > 0) {
            $nik = $penduduk[0]->nik;
            $password = $penduduk[0]->password;

            if (password_verify($input_password, $password)) {
                session_start();

                if (isset($_SESSION['nik'])) {
                    session_regenerate_id(true);
                }

                $_SESSION['nama_admin'] = $penduduk[0]->nama;
                $_SESSION['user_admin'] = $penduduk[0]->username;
                $_SESSION['nik'] = $penduduk[0]->nik;
                $_SESSION['alamat'] = $penduduk[0]->alamat;
                $_SESSION['no_kk'] = $penduduk[0]->no_kk;
                $_SESSION['rt'] = $penduduk[0]->id_rt;
                $_SESSION['rw'] = $penduduk[0]->id_rw;

                if (self::check_if_ketua_rt($nik))
                    $_SESSION['keadaan'] = 'sudah_login_rt';
                else if (self::check_if_ketua_rw($nik))
                    $_SESSION['keadaan'] = 'sudah_login_rw';
                else if (self::check_if_admin($nik))
                    $_SESSION['keadaan'] = 'sudah_login_admin';
                else
                    $_SESSION['keadaan'] = 'sudah_login_penduduk';

                return (object) array(
                    'status' => true,
                    'jenis_session' => $_SESSION['keadaan'],
                    $penduduk[0]
                );
            } else {
                return (object) array(
                    'status' => false,
                    'msg' => 'Data tidak ditemukan'
                );
            }
        } else {
            return (object) array(
                'status' => false,
                'msg' => 'Data tidak ditemukan'
            );
        }
    }

    private static function get_penduduk_by_username(string $username)
    {
        $response = array();
        $stmt = self::$mysqli->prepare("SELECT * FROM penduduk WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($obj = $result->fetch_object()) {
            array_push($response, $obj);
        }
        return $response;
    }

    private static function check_if_ketua_rt(string $nik)
    {
        $stmt = self::$mysqli->prepare("SELECT * FROM msrt where nik_ketuart = ?");
        $stmt->bind_param('s', $nik);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            return true;
        } else {
            return false;
        }
    }

    private static function check_if_ketua_rw(string $nik)
    {
        $stmt = self::$mysqli->prepare("SELECT * FROM msrw where nik_ketuarw = ?");
        $stmt->bind_param('s', $nik);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            return true;
        } else {
            return false;
        }
    }

    private static function check_if_admin(string $nik)
    {
        $stmt = self::$mysqli->prepare("SELECT * FROM msadmin where nik = ?");
        $stmt->bind_param('s', $nik);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            return true;
        } else {
            return false;
        }
    }
}
