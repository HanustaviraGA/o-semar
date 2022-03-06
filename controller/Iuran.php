<?php


class Iuran extends Controller
{
    // TODO: Controller for Web
    public static function get()
    {
    }

    public static function api_get()
    {
        // Prevent XSS and Escape Special Chars
        $nik = self::sanitize($_GET['nik']);
        $status = self::sanitize($_GET['status']);

        if ($status === 'unpaid') {
            $response = self::get_unpaid_iuran($nik);
            return $response;
        } else if ($status === 'paid') {
            $response = self::get_paid_iuran($nik);
            return $response;
        } else {
            return self::response(false, 'Parameter tidak diketahui');
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
    public static function api_post()
    {
        // Prevent XSS and Escape Special Chars
        $nik = self::sanitize($_POST['nik']);
        $id = self::sanitize($_POST['id']);

        $file = $_FILES['files'];
        $tanggal = date('Y-m-d');

        if (isset($file) && !empty($file['name'])) {
            $response = self::insert_lampiran($nik, $id, $tanggal, $file);
            if (!$response->status)
                return $response;
        }
        
        if (!self::get_tagihan($nik, $id)->status) {
            $response = self::update_surat_keterangan($id, false);
            if (!$response->status)
                return $response;
        }
        else {
            $response = self::update_surat_keterangan($id, true);
            if (!$response->status)
                return $response;
        }

        return self::response(true, 'Sukses menghapus data iuran');
    }

    private static function get_unpaid_iuran(string $nik)
    {
        $response = array();

        $stmt = self::$mysqli->prepare(
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
            return self::error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object())
                array_push($response, $obj);
            
            return self::response(true, $response);
        } else
            return self::error('Tidak ada data iuran tersimpan');
    }

    private static function get_paid_iuran(string $nik)
    {
        $response = array();

        $stmt = self::$mysqli->prepare(
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
            return self::error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object())
                array_push($response, (object) array(
                    'bukti_pembayaran' => 'http://localhost/o-semar/api/rest?function=get_berkas&jenis_berkas=iuran&nama_berkas' . $obj->bukti_pembayaran,
                    $obj
                ));

            return self::response(true, $response);
        } else
            return self::error('Tidak ada data iuran yang sudah terbayar tersimpan');
    }

    private static function get_tagihan(string $nik, string $id)
    {
        $response = array();

        $stmt = self::$mysqli->prepare(
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
            return self::error($stmt->error);

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($obj = $result->fetch_object())
                array_push($response, $obj);

            return self::response(true, $response);
        } else
            return self::error('Tidak ada data tagihan tersimpan');
    }

    private static function insert_lampiran(
        string $nik,
        string $id,
        string $tanggal,
        $file
    ) {
        $tagihan = self::get_tagihan($nik, $id);
        if (count($tagihan->data) > 0) {
            foreach ($file['tmp_name'] as $key) {
                $file_tmp = $file['tmp_name'][$key];
                $file_extension = strtolower(pathinfo($file['name'][$key], PATHINFO_EXTENSION));

                if (in_array($file_extension, array('jpg', 'jpeg', 'png', 'gif', 'bmp'))) {
                    $new_filename = uniqid() .  '_' . $nik . '.' . $file_extension;
                    move_uploaded_file($file_tmp, "../admin/iuran/berkas/$new_filename");
                } else
                    return self::error('Ekstensi file tidak dapat diterima');

                $stmt = self::$mysqli->prepare(
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
                    return self::error($stmt->error);

                return self::response(true, 'Berhasil memasukkan data tagihan');
            }
        }
    }

    private static function update_surat_keterangan(string $id, bool $lunas)
    {
        if ($lunas)
            $status = 'Lunas';
        else
            $status = 'Unpaid';

        $stmt = self::$mysqli->prepare(
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
            return self::error($stmt->error);

        return self::response(true, 'Update surat keterangan berhasil');
    }
}
