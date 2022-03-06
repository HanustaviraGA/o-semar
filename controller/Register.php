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
        $no_kk = self::sanitize($_POST['no_kk']);
        $nik = self::sanitize($_POST['nik']);
        $nama = self::sanitize($_POST['nama']);
        $email = self::sanitize($_POST['email']);
        $username = self::sanitize($_POST['username']);
        $password = self::sanitize($_POST['password']);

        if (
            empty($no_kk) ||
            empty($nik) ||
            empty($nama) ||
            empty($email) ||
            empty($username) ||
            empty($password)
        )
            return self::response(false, 'Data tidak boleh kosong');

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
            // Return Error or No Data
            if (!$response->status) {
                return $response;
            }
            return $response;
        } else
            return self::response(false, 'Terdapat pengguna dengan data yang sama');
    }

    /**
     * Cek jika user sudah terdaftar
     * 
     * Mengembalikan object dengan status true or false. Jika false
     * maka user belum terdaftar.
     *
     * @param string $no_kk
     * @param string $nik
     * @param string $nama
     * @param string $username
     * @return object
     */
    private static function check_user_duplicate(
        string $no_kk,
        string $nik,
        string $nama,
        string $username
    ) {
        $stmt = self::$mysqli->prepare(
            "SELECT 
                * 
            FROM 
                penduduk 
            WHERE 
                no_kk = ? AND 
                nik = ? AND 
                nama = ? AND 
                username = ?"
        );
        $stmt->bind_param('ssss', $no_kk, $nik, $nama, $username);
        $stmt->execute();

        if ($stmt->errno !== 0)
            return self::error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows === 0)
            return self::response(false, 'Tidak ada data user yang terdaftar dengan data yang diberikan');
        else
            return self::response(true, 'Ada data user yang terdaftar dengan data yang diberikan');
    }

    private static function create_new_user(
        string $no_kk,
        string $nik,
        string $nama,
        string $email,
        string $username,
        string $hashed_password
    ) {
        $stmt = self::$mysqli->prepare(
            "INSERT INTO 
                penduduk 
            SET 
                no_kk = ?, 
                nik = ?, 
                nama = ?, 
                email = ?, 
                username = ?, 
                password = ?"
        );
        $stmt->bind_param('ssssss', $no_kk, $nik, $nama, $email, $username, $hashed_password);
        $stmt->execute();
        if ($stmt->errno !== 0)
            return self::error($stmt->error);
        else
            return self::response(true, 'Registrasi berhasil');
    }
}
