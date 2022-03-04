<?php

class Penduduk extends Controller
{

    public static function get()
    {
    }

    public static function api_get()
    {
        // TODO: What is filter value?

        $penduduk = self::get_penduduk();

        if (count($penduduk) > 0)
            return (object) array(
                'status' => true,
                $penduduk
            );
        else
            return (object) array(
                'status' => false,
                'error' => 'Tidak ada data'
            );
    }

    private static function get_penduduk() {
        $response = array();

        $stmt = self::$mysqli->prepare("SELECT no_kk, nik, nama, tempat_lahir, tanggal_lahir, alamat, id_rt, id_rw, jenis_kelamin, agama, status_perkawinan, pekerjaan, gol_darah, kewarganegaraan, status_ktp, foto_ktp, email, username, no_hp, tanggal_reg FROM penduduk");
        $stmt->execute();
        $result = $stmt->get_result();

        while ($obj = $result->fetch_object()) {
            array_push($response);
        }

        return $response;
    }
}
