<?php

    /**
 * Login ke akun
 * 
 * @return json
 */
function login()
{
    global $koneksi;

    $filter = $_POST['filter'];
    if (isset($_POST['username']) && $_POST['password']) {
        // Tangkap kiriman data dan antisipasi SQL injection
        $username = $_POST['username'];
        $password = $_POST['password'];
        $esc_username = mysqli_real_escape_string($koneksi, $username);
        $esc_password = mysqli_real_escape_string($koneksi, $password);
        // Cek database
        $data = $koneksi->prepare("SELECT * FROM penduduk WHERE username = ?");
        $data->bind_param('s', $esc_username);
        $data->execute();
        $data_res = $data->get_result();
        if ($data_res->num_rows > 0) {
            $identitas = $data_res->fetch_assoc();
            $nik = $identitas['nik'];
            $password = $identitas['password'];
            // $verify = password_verify($esc_password, $password);
            $verify = $esc_password == $password ? true : false;
            if ($verify) {
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
                // Apakah Super Admin ?
                $data_admin = $koneksi->prepare("SELECT * FROM msadmin where nik=?");
                $data_admin->bind_param('s', $nik);
                $data_admin->execute();
                $data_res_admin = $data_admin->get_result();
                $data_admin_num = $data_res_admin->num_rows;
                // RT
                if ($data_rt_num > 0 && $data_rw_num == 0 && $data_admin_num != 1) {
                    session_start();
                    session_regenerate_id(true);
                    $_SESSION['nama_admin'] = $identitas['nama'];
                    $_SESSION['user_admin'] = $identitas['username'];
                    $_SESSION['nik'] = $identitas['nik'];
                    $_SESSION['no_kk'] = $identitas['no_kk'];
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
                else if ($data_rt_num == 0 && $data_rw_num > 0 && $data_admin_num != 1) {
                    session_start();
                    session_regenerate_id(true);
                    $_SESSION['nama_admin'] = $identitas['nama'];
                    $_SESSION['user_admin'] = $identitas['username'];
                    $_SESSION['nik'] = $identitas['nik'];
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
                else if ($data_rt_num == 0 && $data_rw_num == 0 && $data_admin_num != 1) {
                    session_start();
                    session_regenerate_id(true);
                    $_SESSION['nama_admin'] = $identitas['nama'];
                    $_SESSION['user_admin'] = $identitas['username'];
                    $_SESSION['nik'] = $identitas['nik'];
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
                // Super Admin
                else if ($data_rt_num == 0 && $data_rw_num == 0 && $data_admin_num == 1) {
                    session_start();
                    session_regenerate_id(true);
                    $_SESSION['nama_admin'] = $identitas['nama'];
                    $_SESSION['user_admin'] = $identitas['username'];
                    $_SESSION['nik'] = $identitas['nik'];
                    $_SESSION['no_kk'] = $identitas['no_kk'];
                    $_SESSION['rt'] = $identitas['id_rt'];
                    $_SESSION['rw'] = $identitas['id_rw'];
                    $_SESSION['keadaan'] = "sudah_login_admin";
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
                    header("location:../admin/index.php?pesan=Sukses");
                } else if ($filter == 0) {
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            } else {
                if ($filter == 1) {
                    header("location:../admin/login.php?pesan=Data tidak ditemukan !");
                } else if ($filter == 0) {
                    $response = generate_response(2, 'Data tidak ditemukan');
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            }
        } else {
            if ($filter == 1) {
                header("location:../admin/login.php?pesan=Data tidak ditemukan !");
            } else if ($filter == 0) {
                $response = generate_response(2, 'Data tidak ditemukan');
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
    } else {
        if ($filter == 1) {
            header("location:../admin/login.php?pesan=Data tidak boleh kosong !");
        } else if ($filter == 0) {
            $response = generate_response(2, 'Data tidak boleh kosong');
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
}
