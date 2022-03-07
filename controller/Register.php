<?php

require_once "controller.php";

/**
 * Register controller
 * 
 * @version 2.0.0
 */
class Register extends Controller
{

    // TODO: Controller for Web
    public function post()
    {
    }

    public function api_post()
    {
        // Prevent XSS and Escape Special Chars
        $no_kk = $this->sanitize($_POST['no_kk']);
        $nik = $this->sanitize($_POST['nik']);
        $nama = $this->sanitize($_POST['nama']);
        $email = $this->sanitize($_POST['email']);
        $username = $this->sanitize($_POST['username']);
        $password = $this->sanitize($_POST['password']);

        if (
            empty($no_kk) ||
            empty($nik) ||
            empty($nama) ||
            empty($email) ||
            empty($username) ||
            empty($password)
        )
            return $this->response(false, 'Data tidak boleh kosong');

        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        if (!$this->check_user_duplicate($no_kk, $nik, $nama, $username)) {
            $response = $this->create_new_user(
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
            return $this->response(false, 'Terdapat pengguna dengan data yang sama');
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
    private function check_user_duplicate(
        string $no_kk,
        string $nik,
        string $nama,
        string $username
    ) {
        $stmt = $this->mysqli->prepare(
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
            return $this->error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows === 0)
            return $this->response(false, 'Tidak ada data user yang terdaftar dengan data yang diberikan');
        else
            return $this->response(true, 'Ada data user yang terdaftar dengan data yang diberikan');
    }

    private function create_new_user(
        string $no_kk,
        string $nik,
        string $nama,
        string $email,
        string $username,
        string $hashed_password
    ) {
        $stmt = $this->mysqli->prepare(
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
            return $this->error($stmt->error);
        else
            return $this->response(true, 'Registrasi berhasil');
    }
}
