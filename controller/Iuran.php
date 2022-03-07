<?php

require_once "controller.php";

class Iuran extends Controller
{
    // TODO: Controller for Web
    public function get()
    {
    }

    public function api_get()
    {
        // Prevent XSS and Escape Special Chars
        $nik = $this->sanitize($_GET['nik']);
        $status = $this->sanitize($_GET['status']);

        if ($status === 'unpaid') {
            $response = $this->get_unpaid_iuran($nik);
            return $response;
        } else if ($status === 'paid') {
            $response = $this->get_paid_iuran($nik);
            return $response;
        } else {
            return $this->response(false, 'Parameter tidak diketahui');
        }
    }

    /**
     * Wish can use PUT and DELETE Method, sticking with CRUD concept
     */

    /**
     * Delete data iuran
     *
     * @return object
     */
    public function api_post()
    {
        // Prevent XSS and Escape Special Chars
        $nik = $this->sanitize($_POST['nik']);
        $id = $this->sanitize($_POST['id']);

        $file = $_FILES['files'];
        $tanggal = date('Y-m-d');

        if (isset($file) && !empty($file['name'])) {
            $response = $this->insert_lampiran($nik, $id, $tanggal, $file);
            if (!$response->status)
                return $response;
        }
        
        if (!$this->get_tagihan($nik, $id)->status) {
            $response = $this->update_surat_keterangan($id, false);
            if (!$response->status)
                return $response;
        }
        else {
            $response = $this->update_surat_keterangan($id, true);
            if (!$response->status)
                return $response;
        }

        return $this->response(true, 'Sukses menghapus data iuran');
    }

    private function get_unpaid_iuran(string $nik)
    {
        $response = array();

        $stmt = $this->mysqli->prepare(
            "SELECT 
                nik, 
                id_tagihan, 
                id_rt, 
                id_rw, 
                jenis_tagihan, 
                total_tagihan, 
                jatuh_tempo, 
                status_pembayaran, 
                rekening, 
                bukti_pembayaran, 
                tanggal_pembayaran 
            FROM 
                tagihan 
            WHERE 
                nik = ? AND 
                status_pembayaran = ?"
        );
        $stmt->bind_param('ss', $nik, 'Unpaid');
        $stmt->execute();

        if ($stmt->errno !== 0)
            return $this->error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object())
                array_push($response, $obj);
            
            return $this->response(true, $response);
        } else
            return $this->error('Tidak ada data iuran tersimpan');
    }

    private function get_paid_iuran(string $nik)
    {
        $response = array();

        $stmt = $this->mysqli->prepare(
            "SELECT 
                nik, 
                id_tagihan, 
                id_rt, 
                id_rw, 
                jenis_tagihan, 
                total_tagihan, 
                jatuh_tempo, 
                status_pembayaran, 
                rekening, 
                bukti_pembayaran, 
                tanggal_pembayaran 
            FROM 
                tagihan 
            WHERE 
                nik = ? AND 
                status_pembayaran = ?"
        );
        $stmt->bind_param('ss', $nik, 'Paid');
        $stmt->execute();

        if ($stmt->errno !== 0)
            return $this->error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object())
                array_push($response, (object) array(
                    'bukti_pembayaran' => 'http://localhost/o-semar/api/rest?function=get_berkas&jenis_berkas=iuran&nama_berkas' . $obj->bukti_pembayaran,
                    $obj
                ));

            return $this->response(true, $response);
        } else
            return $this->error('Tidak ada data iuran yang sudah terbayar tersimpan');
    }

    private function get_tagihan(string $nik, string $id)
    {
        $response = array();

        $stmt = $this->mysqli->prepare(
            "SELECT 
                * 
            FROM 
                tagihan 
            WHERE 
                nik = ? AND 
                id_tagihan = ?"
        );
        $stmt->bind_param('ss', $nik, $id);
        $stmt->execute();

        if ($stmt->errno !== 0)
            return $this->error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object())
                array_push($response, $obj);

            return $this->response(true, $response);
        } else
            return $this->error('Tidak ada data tagihan tersimpan');
    }

    private function insert_lampiran(
        string $nik,
        string $id,
        string $tanggal,
        $file
    ) {
        $tagihan = $this->get_tagihan($nik, $id);
        if (count($tagihan->data) > 0) {
            foreach ($file['tmp_name'] as $key) {
                $file_tmp = $file['tmp_name'][$key];
                $file_extension = strtolower(pathinfo($file['name'][$key], PATHINFO_EXTENSION));

                if (in_array($file_extension, array('jpg', 'jpeg', 'png', 'gif', 'bmp'))) {
                    $new_filename = uniqid() .  '_' . $nik . '.' . $file_extension;
                    move_uploaded_file($file_tmp, "../admin/iuran/berkas/$new_filename");
                } else
                    return $this->error('Ekstensi file tidak dapat diterima');

                $stmt = $this->mysqli->prepare(
                    "INSERT INTO lampiran
                        (
                            nik, 
                            kode, 
                            lampiran, 
                            jenis_lampiran, 
                            tanggal_lampiran, 
                            status_lampiran, 
                            ket_lampiran
                            ) 
                    VALUES
                        (
                            ?, 
                            ?, 
                            ?, 
                            'Pembayaran Tagihan', 
                            ?, 
                            'Unpaid', 
                            '-'
                        )"
                );
                $stmt->bind_param('ssss', $nik, $id, $new_filename, $tanggal);
                $stmt->execute();

                if ($stmt->errno !== 0)
                    return $this->error($stmt->error);

                return $this->response(true, 'Berhasil memasukkan data tagihan');
            }
        }
    }

    private function update_surat_keterangan(string $id, bool $lunas)
    {
        if ($lunas)
            $status = 'Lunas';
        else
            $status = 'Unpaid';

        $stmt = $this->mysqli->prepare(
            "UPDATE 
                tagihan 
            SET 
                status_pembayaran = ? 
            WHERE 
                id_tagihan = ?"
        );
        $stmt->bind_param('ss', $status, $id);
        $stmt->execute();

        if ($stmt->errno !== 0)
            return $this->error($stmt->error);

        return $this->response(true, 'Update surat keterangan berhasil');
    }
}
