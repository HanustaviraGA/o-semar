<?php

require_once "controller.php";

/**
 * Lampiran controller
 * 
 * @version 2.0.0
 */
class Lampiran extends Controller
{
    // TODO: Controller for Web
    public function get()
    {
    }

    public function api_get()
    {
        // Prevent XSS and Escape Special Chars
        $id = $this->sanitize($_GET['id']);
        $jenis_lampiran = $this->sanitize($_GET['jenis_lampiran']);

        switch ($jenis_lampiran) {
            case 'pelaporan': {
                    $response = $this->get_lampiran_pelaporan($id);
                    break;
                }
            case 'surat': {
                    $response = $this->get_lampiran_surat($id);
                    break;
                }
            case 'pengumuman': {
                    $response = $this->get_lampiran_pengumuman($id);
                    break;
                }
            case 'iuran': {
                    $response = $this->get_lampiran_iuran($id);
                    break;
                }
            default: {
                    if (empty($jenis_lampiran))
                        return $this->error("Jenis lampiran null tidak tersedia");
                    return $this->error("Jenis lampiran $jenis_lampiran tidak tersedia");
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
            return $this->response(true, $data);
        } else
            return $this->error("Tidak ada data lampiran $jenis_lampiran pada database");
    }

    private function get_lampiran_pelaporan(string $id)
    {
        $data = array();
        $jenis_lampiran = 'Laporan Masyarakat';

        $stmt = $this->mysqli->prepare(
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
        $stmt->bind_param('ss', $id, $jenis_lampiran);
        $stmt->execute();

        if ($stmt->errno !== 0)
            return $this->error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object()) 
                array_push($data, $obj);
    
            return $this->response(true, $data);
        } else
            return $this->response(false, 'Data tidak ditemukan');
    }

    private function get_lampiran_surat(string $id)
    {
        $data = array();
        $jenis_lampiran = 'Pengajuan Surat';

        $stmt = $this->mysqli->prepare(
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
        $stmt->bind_param('ss', $id, $jenis_lampiran);
        $stmt->execute();

        if ($stmt->errno !== 0)
            return $this->error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object()) {
                array_push($data, $obj);
            }
    
            return $this->response(true, $data);
        } else
            return $this->response(false, 'Data tidak ditemukan');
    }

    private function get_lampiran_pengumuman(string $id)
    {
        $data = array();
        $jenis_lampiran = 'Pengajuan Warga';

        $stmt = $this->mysqli->prepare(
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
        $stmt->bind_param('ss', $id, $jenis_lampiran);
        $stmt->execute();
        
        if ($stmt->errno !== 0)
            return $this->error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object()) {
                array_push($data, $obj);
            }
    
            return $this->response(true, $data);
        } else
            return $this->response(false, 'Data tidak ditemukan');
    }

    private function get_lampiran_iuran(string $id)
    {
        $data = array();
        $jenis_lampiran = 'Pembayaran Tagihan';

        $stmt = $this->mysqli->prepare(
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
        $stmt->bind_param('ss', $id, $jenis_lampiran);
        $stmt->execute();
        
        if ($stmt->errno !== 0)
            return $this->error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object()) {
                array_push($data, $obj);
            }
    
            return $this->response(true, $data);
        } else
            return $this->response(false, 'Data tidak ditemukan');
    }
}
