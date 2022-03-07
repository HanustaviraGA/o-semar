<?php

require_once "controller.php";

class Login extends Controller
{

    // TODO: Controller for Web
    public function post()
    {
    }

    public function api_post()
    {
        // Prevent XSS and Escape Special Chars
        $username = $this->sanitize($_POST['username']);
        $input_password = $this->sanitize($_POST['password']);
        // Check request data
        if (empty($username) || empty($input_password)) {
            return $this->response(false, 'Data tidak boleh kosong');
        }
        // 
        $penduduk = $this->get_penduduk_by_username($username);
        if (count($penduduk->data) > 0) {
            $nik = $penduduk->data[0]->nik;
            $password = $penduduk->data[0]->password;

            if (password_verify($input_password, $password)) {
                session_start();

                if (isset($_SESSION['nik'])) {
                    session_regenerate_id(true);
                }

                $_SESSION['nama_admin'] = $penduduk->data[0]->nama;
                $_SESSION['user_admin'] = $penduduk->data[0]->username;
                $_SESSION['nik'] = $penduduk->data[0]->nik;
                $_SESSION['alamat'] = $penduduk->data[0]->alamat;
                $_SESSION['no_kk'] = $penduduk->data[0]->no_kk;
                $_SESSION['rt'] = $penduduk->data[0]->id_rt;
                $_SESSION['rw'] = $penduduk->data[0]->id_rw;

                if ($this->check_if_ketua_rt($nik))
                    $_SESSION['keadaan'] = 'sudah_login_rt';
                else if ($this->check_if_ketua_rw($nik))
                    $_SESSION['keadaan'] = 'sudah_login_rw';
                else if ($this->check_if_admin($nik))
                    $_SESSION['keadaan'] = 'sudah_login_admin';
                else
                    $_SESSION['keadaan'] = 'sudah_login_penduduk';

                return $this->response(true, (object) array(
                    'jenis_session' => $_SESSION['keadaan'],
                    $penduduk->data[0]
                ));
            } else {
                return $this->response(false, 'Username atau Password salah!');
            }
        } else {
            return $this->response(false, 'Data user tidak ditemukan');
        }
    }

    private function get_penduduk_by_username(string $username)
    {
        $response = array();
        $stmt = $this->mysqli->prepare(
            "SELECT 
                * 
            FROM 
                penduduk 
            WHERE 
                username = ?"
        );
        $stmt->bind_param('s', $username);
        $stmt->execute();

        if ($stmt->errno !== 0)
            return $this->error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object()) {
                array_push($response, $obj);
            }
    
            return $this->response(true, $response);
        } else
            return $this->response(false, 'Data tidak ditemukan');
    }

    private function check_if_ketua_rt(string $nik)
    {
        $stmt = $this->mysqli->prepare(
            "SELECT 
                * 
            FROM 
                msrt 
            WHERE 
                nik_ketuart = ?"
        );
        $stmt->bind_param('s', $nik);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            return true;
        } else {
            return false;
        }
    }

    private function check_if_ketua_rw(string $nik)
    {
        $stmt = $this->mysqli->prepare(
            "SELECT 
                * 
            FROM 
                msrw 
            WHERE 
                nik_ketuarw = ?"
        );
        $stmt->bind_param('s', $nik);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            return true;
        } else {
            return false;
        }
    }

    private function check_if_admin(string $nik)
    {
        $stmt = $this->mysqli->prepare(
            "SELECT 
                * 
            FROM 
                msadmin 
            WHERE 
                nik = ?"
        );
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
