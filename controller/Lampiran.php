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
        $id = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_GET('id'), ENT_COMPAT)
        );
        $jenis_lampiran = mysqli_real_escape_string(
            self::$mysqli,
            htmlspecialchars($_GET('jenis_lampiran'), ENT_COMPAT)
        );

        switch ($jenis_lampiran) {
            case 'pelaporan': {
                    $data = self::get_lampiran_pelaporan($id);
                    break;
                }
            case 'surat': {
                    $data = self::get_lampiran_surat($id);
                    break;
                }
            case 'pengumuman': {
                    $data = self::get_lampiran_pengumuman($id);
                    break;
                }
            case 'iuran': {
                    $data = self::get_lampiran_iuran($id);
                    break;
                }
            default: {
                    return (object) array(
                        'status' => false,
                        'error' => "Jenis lampiran $jenis_lampiran tidak tersedia"
                    );
                }
        }

        if (count($data) > 0) {
            $basepath = "http://localhost/o-semar";
            $response = array();

            foreach ($data as $val) {
                $filename = "$basepath/admin/berkas/$jenis_lampiran/" . $val['lampiran'];
                array_push($response, array(
                    'id_pelaporan' => $val['id_pelaporan'],
                    'nama_lampiran' => $val['lampiran'],
                    'status_lampiran' => $val['status_lampiran'],
                    'ket_lampiran' => $val['ket_lampiran'],
                    'ekstensi_lampiran' => pathinfo(urlencode($filename), PATHINFO_EXTENSION),
                    'data_lampiran' => "http://localhost/o-semar/api/rest?function=get_berkas&key=buwinakeren&jenis_berkas=$jenis_lampiran&nama_berkas=" . $val["lampiran"]
                ));
            }
            return (object) array(
                'status' => true,
                'data' => $response
            );
        } else {
            return (object) array(
                'status' => false,
                'error' => "Tidak ada data lampiran $jenis_lampiran pada database"
            );
        }
    }

    private static function get_lampiran_pelaporan(string $id)
    {
        $data = array();

        $stmt = self::$mysqli->prepare("SELECT pelaporan.id_pelaporan, lampiran, jenis_lampiran, status_lampiran, ket_lampiran
        FROM pelaporan INNER JOIN lampiran ON lampiran.kode = pelaporan.id_pelaporan
        WHERE pelaporan.id_pelaporan = ? AND jenis_lampiran = ?");
        $stmt->bind_param('ss', $id, 'Laporan Masyarakat');
        $stmt->execute();
        $result = $stmt->get_result();

        while ($obj = $result->fetch_object()) {
            array_push($data, $obj);
        }

        return $data;
    }

    private static function get_lampiran_surat(string $id)
    {
        $data = array();

        $stmt = self::$mysqli->prepare("SELECT suratketerangan.no_surat, lampiran, jenis_lampiran, status_lampiran, ket_lampiran
                    FROM suratketerangan INNER JOIN lampiran ON lampiran.kode = suratketerangan.no_surat
                    WHERE suratketerangan.no_surat = ? AND jenis_lampiran = ?");
        $stmt->bind_param('ss', $id, 'Pengajuan Surat');
        $stmt->execute();
        $result = $stmt->get_result();

        while ($obj = $result->fetch_object()) {
            array_push($data, $obj);
        }

        return $data;
    }

    private static function get_lampiran_pengumuman(string $id)
    {
        $data = array();

        $stmt = self::$mysqli->prepare("SELECT pengumuman.id, lampiran, jenis_lampiran, status_lampiran, ket_lampiran
        FROM pengumuman INNER JOIN lampiran ON lampiran.kode = pengumuman.id
        WHERE pengumuman.id = ? AND jenis_lampiran = ?");
        $stmt->bind_param('ss', $id, 'Pengajuan Warga');
        $stmt->execute();
        $result = $stmt->get_result();

        while ($obj = $result->fetch_object()) {
            array_push($data, $obj);
        }

        return $data;
    }

    private static function get_lampiran_iuran(string $id)
    {
        $data = array();

        $stmt = self::$mysqli->prepare("SELECT tagihan.id_tagihan, lampiran, jenis_lampiran, status_lampiran, ket_lampiran
                    FROM tagihan INNER JOIN lampiran ON lampiran.kode = tagihan.id_tagihan
                    WHERE tagihan.id_tagihan = ? AND jenis_lampiran = ?");
        $stmt->bind_param('ss', $id, 'Pembayaran Tagihan');
        $stmt->execute();
        $result = $stmt->get_result();
        while ($obj = $result->fetch_object()) {
            array_push($data, $obj);
        }

        return $data;
    }
}
