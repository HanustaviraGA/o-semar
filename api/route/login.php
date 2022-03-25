<?php

/**
 * Login ke akun
 * 
 * @return json
 */
function login()
{
    global $koneksi;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $filter = $_POST['filter'];
        if (isset($_POST['username']) && $_POST['password']) {
            // Tangkap kiriman data dan antisipasi SQL injection
            $username = $_POST['username'];
            $password = $_POST['password'];
            $esc_username = mysqli_real_escape_string($koneksi, $username);
            $esc_password = mysqli_real_escape_string($koneksi, $password);
            // Cek database penduduk
            $data = $koneksi->prepare("SELECT * FROM penduduk WHERE username = ?");
            $data->bind_param('s', $esc_username);
            $data->execute();
            $data_res = $data->get_result();
            // Cek database admin 
            $data_admin = $koneksi->prepare("SELECT * FROM msadmin where username=?");
            $data_admin->bind_param('s', $esc_username);
            $data_admin->execute();
            $data_res_admin = $data_admin->get_result();
            // Penduduk, RT, RW
            if ($data_res->num_rows > 0 && $data_res_admin->num_rows == 0) {
                $identitas = $data_res->fetch_assoc();
                $nik = $identitas['nik'];
                $acc_status = $identitas['acc_status'];
                $password = $identitas['password'];
                $verify = password_verify($esc_password, $password);
                // $verify = $esc_password == $password ? true : false;
                if ($verify && $acc_status != '0') {
                    // Cek apakah penduduk ini Penduduk Biasa, RT, RW, atau Super Admin
                    // Apakah RT ?
                    $data_rt = $koneksi->prepare("SELECT * FROM msrt where nik_ketuart=?");
                    $data_rt->bind_param('s', $nik);
                    $data_rt->execute();
                    $data_res_rt = $data_rt->get_result();
                    $data_rt_num = $data_res_rt->num_rows;
                    // Apakah RW ?
                    $data_rw = $koneksi->prepare("SELECT * FROM msrw where nik_ketuarw=?");
                    $data_rw->bind_param('s', $nik);
                    $data_rw->execute();
                    $data_res_rw = $data_rw->get_result();
                    $data_rw_num = $data_res_rw->num_rows;
                    // RT
                    if ($data_rt_num > 0 && $data_rw_num == 0) {
                        session_start();
                        session_regenerate_id(true);
                        // ========================
                        // Generate CSRF Token
                        // ========================
                        // generate_token();
                        // ========================
                        $_SESSION['nama_admin'] = $identitas['nama'];
                        $_SESSION['user_admin'] = $identitas['username'];
                        $_SESSION['nik'] = $identitas['nik'];
                        $_SESSION['no_kk'] = $identitas['no_kk'];
                        $_SESSION['alamat'] = $identitas['alamat'];
                        $_SESSION['rt'] = $identitas['id_rt'];
                        $_SESSION['rw'] = $identitas['id_rw'];
                        $_SESSION['keadaan'] = "sudah_login_rt";
                        $response = generate_response(1, 'Sukses', array(
                            'no_kk' => $identitas['no_kk'],
                            'nik' => $identitas['nik'],
                            'nama' => $identitas['nama'],
                            'tempat_lahir' => $identitas['tempat_lahir'],
                            'tanggal_lahir' => $identitas['tanggal_lahir'],
                            'alamat' => $identitas['alamat'],
                            'id_rt' => $identitas['id_rt'],
                            'id_rw' => $identitas['id_rw'],
                            'jenis_kelamin' => $identitas['jenis_kelamin'],
                            'agama' => $identitas['agama'],
                            'status_perkawinan' => $identitas['status_perkawinan'],
                            'pekerjaan' => $identitas['pekerjaan'],
                            'gol_darah' => $identitas['gol_darah'],
                            'kewarganegaraan' => $identitas['kewarganegaraan'],
                            'status_ktp' => $identitas['status_ktp'],
                            'foto_ktp' => $identitas['foto_ktp'],
                            'email' => $identitas['email'],
                            'username' => $identitas['username'],
                            'no_hp' => $identitas['no_hp'],
                            'status_hubungan_keluarga' => $identitas['status_hubungan_keluarga'],
                            'no_paspor' => $identitas['no_paspor'],
                            'no_kitas' => $identitas['no_kitas'],
                            'kepala_keluarga' => $identitas['kepala_keluarga'],
                            'nama_ayah' => $identitas['nama_ayah'],
                            'nama_ibu' => $identitas['nama_ibu'],
                            'virtual_account_id' => $identitas['virtual_account_id'],
                            'foto_kk' => $identitas['foto_kk'],
                            'pendidikan' => $identitas['pendidikan'],
                            'tanggal_pengeluaran_kk' => $identitas['tanggal_pengeluaran_kk'],
                            'tanggal_reg' => $identitas['tanggal_reg'],
                            'jenis_session' => $_SESSION['keadaan']
                        ));
                    }
                    // RW
                    else if ($data_rt_num == 0 && $data_rw_num > 0) {
                        session_start();
                        session_regenerate_id(true);
                        // ========================
                        // Generate CSRF Token
                        // ========================
                        // generate_token();
                        // ========================
                        $_SESSION['nama_admin'] = $identitas['nama'];
                        $_SESSION['user_admin'] = $identitas['username'];
                        $_SESSION['nik'] = $identitas['nik'];
                        $_SESSION['alamat'] = $identitas['alamat'];
                        $_SESSION['no_kk'] = $identitas['no_kk'];
                        $_SESSION['rt'] = $identitas['id_rt'];
                        $_SESSION['rw'] = $identitas['id_rw'];
                        $_SESSION['keadaan'] = "sudah_login_rw";
                        $response = generate_response(1, 'Sukses', array(
                            'no_kk' => $identitas['no_kk'],
                            'nik' => $identitas['nik'],
                            'nama' => $identitas['nama'],
                            'tempat_lahir' => $identitas['tempat_lahir'],
                            'tanggal_lahir' => $identitas['tanggal_lahir'],
                            'alamat' => $identitas['alamat'],
                            'id_rt' => $identitas['id_rt'],
                            'id_rw' => $identitas['id_rw'],
                            'jenis_kelamin' => $identitas['jenis_kelamin'],
                            'agama' => $identitas['agama'],
                            'status_perkawinan' => $identitas['status_perkawinan'],
                            'pekerjaan' => $identitas['pekerjaan'],
                            'gol_darah' => $identitas['gol_darah'],
                            'kewarganegaraan' => $identitas['kewarganegaraan'],
                            'status_ktp' => $identitas['status_ktp'],
                            'foto_ktp' => $identitas['foto_ktp'],
                            'email' => $identitas['email'],
                            'username' => $identitas['username'],
                            'no_hp' => $identitas['no_hp'],
                            'status_hubungan_keluarga' => $identitas['status_hubungan_keluarga'],
                            'no_paspor' => $identitas['no_paspor'],
                            'no_kitas' => $identitas['no_kitas'],
                            'kepala_keluarga' => $identitas['kepala_keluarga'],
                            'nama_ayah' => $identitas['nama_ayah'],
                            'nama_ibu' => $identitas['nama_ibu'],
                            'virtual_account_id' => $identitas['virtual_account_id'],
                            'foto_kk' => $identitas['foto_kk'],
                            'pendidikan' => $identitas['pendidikan'],
                            'tanggal_pengeluaran_kk' => $identitas['tanggal_pengeluaran_kk'],
                            'tanggal_reg' => $identitas['tanggal_reg'],
                            'jenis_session' => $_SESSION['keadaan']
                        ));
                    }
                    // Penduduk
                    else if ($data_rt_num == 0 && $data_rw_num == 0) {
                        session_start();
                        session_regenerate_id(true);
                        // ========================
                        // Generate CSRF Token
                        // ========================
                        // generate_token();
                        // ========================
                        $_SESSION['nama_admin'] = $identitas['nama'];
                        $_SESSION['user_admin'] = $identitas['username'];
                        $_SESSION['nik'] = $identitas['nik'];
                        $_SESSION['alamat'] = $identitas['alamat'];
                        $_SESSION['no_kk'] = $identitas['no_kk'];
                        $_SESSION['rt'] = $identitas['id_rt'];
                        $_SESSION['rw'] = $identitas['id_rw'];
                        $_SESSION['keadaan'] = "sudah_login_penduduk";
                        $response = generate_response(1, 'Sukses', array(
                            'no_kk' => $identitas['no_kk'],
                            'nik' => $identitas['nik'],
                            'nama' => $identitas['nama'],
                            'tempat_lahir' => $identitas['tempat_lahir'],
                            'tanggal_lahir' => $identitas['tanggal_lahir'],
                            'alamat' => $identitas['alamat'],
                            'id_rt' => $identitas['id_rt'],
                            'id_rw' => $identitas['id_rw'],
                            'jenis_kelamin' => $identitas['jenis_kelamin'],
                            'agama' => $identitas['agama'],
                            'status_perkawinan' => $identitas['status_perkawinan'],
                            'pekerjaan' => $identitas['pekerjaan'],
                            'gol_darah' => $identitas['gol_darah'],
                            'kewarganegaraan' => $identitas['kewarganegaraan'],
                            'status_ktp' => $identitas['status_ktp'],
                            'foto_ktp' => $identitas['foto_ktp'],
                            'email' => $identitas['email'],
                            'username' => $identitas['username'],
                            'no_hp' => $identitas['no_hp'],
                            'status_hubungan_keluarga' => $identitas['status_hubungan_keluarga'],
                            'no_paspor' => $identitas['no_paspor'],
                            'no_kitas' => $identitas['no_kitas'],
                            'kepala_keluarga' => $identitas['kepala_keluarga'],
                            'nama_ayah' => $identitas['nama_ayah'],
                            'nama_ibu' => $identitas['nama_ibu'],
                            'virtual_account_id' => $identitas['virtual_account_id'],
                            'foto_kk' => $identitas['foto_kk'],
                            'pendidikan' => $identitas['pendidikan'],
                            'tanggal_pengeluaran_kk' => $identitas['tanggal_pengeluaran_kk'],
                            'tanggal_reg' => $identitas['tanggal_reg'],
                            'jenis_session' => $_SESSION['keadaan']
                        ));
                    }
                    // Cek apa ini web atau mobile yang kirim
                    if ($filter == 1) {
                        header("Location: ../admin/views/index?pesan=sukses_penduduk");
                    } else if ($filter == 0) {
                        header("HTTP/ 200");
                        header('Content-Type: application/json');
                        echo json_encode($response);
                        exit();
                    }
                } else {
                    if ($filter == 1) {
                        header("Location: ../admin/views/login?pesan=gagal_penduduk");
                    } else if ($filter == 0) {
                        $response = generate_response(2, 'Data tidak ditemukan');
                        header("HTTP/ 500");
                        header('Content-Type: application/json');
                        echo json_encode($response);
                        exit();
                    }
                }
            }else if ($data_res->num_rows == 0 && $data_res_admin->num_rows > 0) {
                // Super Admin
                $identitas = $data_res_admin->fetch_assoc();
                $nik = $identitas['nik'];
                $password = $identitas['password'];
                $acc_status = $identitas['acc_status'];
                $verify = password_verify($esc_password, $password);
                // $verify = $esc_password == $password ? true : false;
                if ($verify && $acc_status != '0') {
                    session_start();
                    session_regenerate_id(true);
                    // ========================
                    // Generate CSRF Token
                    // ========================
                    // generate_token();
                    // ========================
                    $_SESSION['nama_admin'] = $identitas['nama'];
                    $_SESSION['user_admin'] = $identitas['username'];
                    $_SESSION['nik'] = $identitas['nik'];
                    $_SESSION['alamat'] = $identitas['alamat'];
                    $_SESSION['no_kk'] = $identitas['no_kk'];
                    $_SESSION['rt'] = $identitas['id_rt'];
                    $_SESSION['rw'] = $identitas['id_rw'];
                    $_SESSION['keadaan'] = "sudah_login_admin";
                    header("Location: ../admin/views/index?pesan=sukses_admin");
                }else{
                    header("Location: ../admin/views/index?pesan=gagal_admin");
                }
            }else{
                header("Location: ../admin/views/login?pesan=gagal_nodata");
            }
        } else {
            header("Location: ../admin/views/login?pesan=gagal");
        }
    } else {
        header("Location: ../admin/views/login?pesan=gagal");
    }
}
