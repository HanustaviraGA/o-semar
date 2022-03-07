<?php

require_once "controller.php";

class Profile extends Controller
{
    // TODO: Controller for Web
    public function post()
    {
    }

    public function api_post()
    {
        $nik = $this->sanitize($_POST['nik']);
        $nik_baru = $this->sanitize($_POST['nik_baru']);
        $kk = $this->sanitize($_POST['kk']);
        $email = $this->sanitize($_POST['email']);
        $username = $this->sanitize($_POST['username']);
        $password = $this->sanitize($_POST['password']);
        

        $penduduk = $this->get_user($nik);
        if (count($penduduk) > 0) {
            if (!empty($password)) {
                // Update Password
                $response = $this->update_password($nik, $password);
            } else {
                // Update Profile
                $response = $this->update_profile(
                    $nik,
                    $nik_baru,
                    $kk,
                    $email,
                    $username
                );
            }
            return $response;
        } else
            return $this->response(false, 'Data tidak ditemukan');
        
    }

    private function get_user(string $nik)
    {
        $response = array();

        $stmt = $this->mysqli->prepare(
            "SELECT 
                * 
            FROM 
                penduduk 
            WHERE 
                nik = ?"
        );
        $stmt->bind_param('s', $nik);
        $stmt->execute();

        if ($stmt->errno !== 0)
            return $this->error($stmt->error);
        
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object())
                array_push($response, $obj);
    
            return $this->response(true, $response);
        } else
            return $this->response(false, 'Data tidak ditemukan');
    }

    private function update_profile(
        string $nik,
        string $nik_baru,
        string $kk,
        string $email,
        string $username
    ) {
        $stmt = $this->mysqli->prepare(
            "UPDATE 
                penduduk 
            SET 
                no_kk = ?, 
                nik = ?, 
                email = ?, 
                username = ? 
            WHERE 
                nik = ?"
        );
        $stmt->bind_param('sssss', $kk, $nik_baru, $email, $username, $nik);
        $stmt->execute();

        if ($stmt->errno !== 0) 
            return $this->error($stmt->error);

        return $this->response(true, 'Update sukses');
    }

    private function update_password(
        string $nik,
        string $password
    ) {
        $stmt = $this->mysqli->prepare(
            "UPDATE 
                penduduk 
            SET 
                password = ? 
            WHERE 
                nik = ?"
        );
        $stmt->bind_param('s', password_hash($password, PASSWORD_DEFAULT), $nik);
        $stmt->execute();

        if ($stmt->errno !== 0) 
        return $this->error($stmt->error);

        return $this->response(true, 'Update sukses');
    }
}
