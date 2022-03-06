<?php

/**
 * Lampiran controller
 * 
 * @version 2.0.0
 */
class Lampiran extends Controller
{
    // TODO: Controller for Web
    public static function get()
    {
    }

    public static function api_get()
    {
        // Prevent XSS and Escape Special Chars
        $id = self::sanitize($_GET['id']);
        $jenis_lampiran = self::sanitize($_GET['jenis_lampiran']);

        switch ($jenis_lampiran) {
            case 'pelaporan': {
                    $response = self::get_lampiran_pelaporan($id);
                    break;
                }
            case 'surat': {
                    $response = self::get_lampiran_surat($id);
                    break;
                }
            case 'pengumuman': {
                    $response = self::get_lampiran_pengumuman($id);
                    break;
                }
            case 'iuran': {
                    $response = self::get_lampiran_iuran($id);
                    break;
                }
            default: {
                    return self::error("Jenis lampiran $jenis_lampiran tidak tersedia");
                }
        }

        if (!$response->status)
            return $response;

        if (count($response->data) > 0) {
            $basepath = "http://localhost/o-semar";
            $data = array();

            foreach ($response as $val) {
                $filename = "$basepath/admin/berkas/$jenis_lampiran/" . $val['lampiran'];
                array_push($data, array(
                    'id_pelaporan' => $val['id_pelaporan'],
                    'nama_lampiran' => $val['lampiran'],
                    'status_lampiran' => $val['status_lampiran'],
                    'ket_lampiran' => $val['ket_lampiran'],
                    'ekstensi_lampiran' => pathinfo(urlencode($filename), PATHINFO_EXTENSION),
                    'data_lampiran' => "http://localhost/o-semar/api/rest?function=get_berkas&key=buwinakeren&jenis_berkas=$jenis_lampiran&nama_berkas=" . $val["lampiran"]
                ));
            }
            return self::response(true, $data);
        } else
            return self::error("Tidak ada data lampiran $jenis_lampiran pada database");
    }

    private static function get_lampiran_pelaporan(string $id)
    {
        $data = array();

        $stmt = self::$mysqli->prepare(
            "SELECT 
                pelaporan.id_pelaporan, 
                lampiran, 
                jenis_lampiran, 
                status_lampiran, 
                ket_lampiran
            FROM 
                pelaporan 
            INNER JOIN 
                lampiran ON lampiran.kode = pelaporan.id_pelaporan
            WHERE 
                pelaporan.id_pelaporan = ? AND 
                jenis_lampiran = ?"
        );
        $stmt->bind_param('ss', $id, 'Laporan Masyarakat');
        $stmt->execute();

        if ($stmt->errno !== 0)
            return self::error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object()) 
                array_push($data, $obj);
    
            return self::response(true, $data);
        } else
            return self::response(false, 'Data tidak ditemukan');
    }

    private static function get_lampiran_surat(string $id)
    {
        $data = array();

        $stmt = self::$mysqli->prepare(
            "SELECT 
                suratketerangan.no_surat, 
                lampiran, 
                jenis_lampiran, 
                status_lampiran, 
                ket_lampiran
            FROM 
                suratketerangan 
            INNER JOIN 
                lampiran ON lampiran.kode = suratketerangan.no_surat
            WHERE 
                suratketerangan.no_surat = ? AND 
                jenis_lampiran = ?"
        );
        $stmt->bind_param('ss', $id, 'Pengajuan Surat');
        $stmt->execute();

        if ($stmt->errno !== 0)
            return self::error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object()) {
                array_push($data, $obj);
            }
    
            return self::response(true, $data);
        } else
            return self::response(false, 'Data tidak ditemukan');
    }

    private static function get_lampiran_pengumuman(string $id)
    {
        $data = array();

        $stmt = self::$mysqli->prepare(
            "SELECT 
                pengumuman.id, 
                lampiran, 
                jenis_lampiran, 
                status_lampiran, 
                ket_lampiran
            FROM 
                pengumuman 
            INNER JOIN 
                lampiran ON lampiran.kode = pengumuman.id
            WHERE 
                pengumuman.id = ? AND 
                jenis_lampiran = ?"
        );
        $stmt->bind_param('ss', $id, 'Pengajuan Warga');
        $stmt->execute();
        
        if ($stmt->errno !== 0)
            return self::error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object()) {
                array_push($data, $obj);
            }
    
            return self::response(true, $data);
        } else
            return self::response(false, 'Data tidak ditemukan');
    }

    private static function get_lampiran_iuran(string $id)
    {
        $data = array();

        $stmt = self::$mysqli->prepare(
            "SELECT 
                tagihan.id_tagihan, 
                lampiran, 
                jenis_lampiran, 
                status_lampiran,
                ket_lampiran
            FROM 
                tagihan 
            INNER JOIN 
                lampiran ON lampiran.kode = tagihan.id_tagihan
            WHERE 
                tagihan.id_tagihan = ? AND 
                jenis_lampiran = ?"
        );
        $stmt->bind_param('ss', $id, 'Pembayaran Tagihan');
        $stmt->execute();
        
        if ($stmt->errno !== 0)
            return self::error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object()) {
                array_push($data, $obj);
            }
    
            return self::response(true, $data);
        } else
            return self::response(false, 'Data tidak ditemukan');
    }
}
