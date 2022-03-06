<?php
include_once '../../../../koneksi.php';

if(isset($_POST["submit_file"])){
    $file = $_FILES["file"]["tmp_name"];
    $file_open = fopen($file,"r");
    while(($csv = fgetcsv($file_open, 1000, ";")) !== false){
        $no_kk = $csv[0];
        $nik = $csv[1];
        $nama= $csv[2];
        $tempat_lahir = $csv[3];
        $tanggal_lahir = $csv[4];
        $alamat = $csv[5];
        $id_rt = $csv[6];
        $id_rw = $csv[7];
        $jenis_kelamin = $csv[8];
        $agama = $csv[9];
        $status_perkawinan = $csv[10];
        $pekerjaan = $csv[11];
        $gol_darah = $csv[12];
        $kewarganegaraan = $csv[13];
        $status_ktp = $csv[14];
        $no_hp = $csv[15];
        $no_paspor = $csv[16];
        $no_kitas = $csv[17];
        $nama_ayah = $csv[18];
        $nama_ibu = $csv[19];
        $pendidikan = $csv[20];
        mysqli_query($koneksi, "INSERT INTO penduduk(
            no_kk, nik, nama, tempat_lahir, tanggal_lahir, alamat, id_rt, id_rw, jenis_kelamin, agama,
            status_perkawinan, pekerjaan, gol_darah, kewarganegaraan, status_ktp, no_hp, no_paspor, no_kitas, 
            nama_ayah, nama_ibu, pendidikan
        ) VALUES (
            '$no_kk', '$nik', '$nama', '$tempat_lahir', '$tanggal_lahir', '$alamat', '$id_rt', '$id_rw',
            '$jenis_kelamin', '$agama', '$status_perkawinan', '$pekerjaan', '$gol_darah', '$kewarganegaraan',
            '$status_ktp', '$no_hp', '$no_paspor', '$no_kitas','$nama_ayah', '$nama_ibu', '$pendidikan'
        )");
    }
    header("Location:update.php?pesan=sukses");
}else if (isset($_GET["export_file"])){
    @header("Content-Disposition: attachment; filename=Data Penduduk.csv");
    $select = mysqli_query($koneksi, "SELECT no_kk, nik, nama, tempat_lahir, tanggal_lahir,
    alamat, id_rt, id_rw, jenis_kelamin, agama, status_perkawinan, pekerjaan, gol_darah,
    kewarganegaraan, status_ktp, foto_ktp, email, username, no_hp, status_hubungan_keluarga,
    no_paspor, no_kitas, kepala_keluarga, nama_ayah, nama_ibu, virtual_account_id, foto_kk,
    pendidikan, tanggal_pengeluaran_kk, tanggal_reg FROM penduduk");
    while($row=mysqli_fetch_array($select)){
        $data.=$row['no_kk'].";";
        $data.=$row['nik'].";";
        $data.=$row['tempat_lahir'].";";
        $data.=$row['tanggal_lahir'].";";
        $data.=$row['alamat'].";";
        $data.=$row['id_rt'].";";
        $data.=$row['id_rw'].";";
        $data.=$row['jenis_kelamin'].";";
        $data.=$row['agama'].";";
        $data.=$row['status_perkawinan'].";";
        $data.=$row['pekerjaan'].";";
        $data.=$row['gol_darah'].";";
        $data.=$row['kewarganegaraan'].";";
        $data.=$row['status_ktp'].";";
        $data.=$row['foto_ktp'].";";
        $data.=$row['email'].";";
        $data.=$row['no_hp'].";";
        $data.=$row['status_hubungan_keluarga'].";";
        $data.=$row['no_paspor'].";";
        $data.=$row['no_kitas'].";";
        $data.=$row['kepala_keluarga'].";";
        $data.=$row['nama_ayah'].";";
        $data.=$row['nama_ibu'].";";
        $data.=$row['virtual_account_id'].";";
        $data.=$row['foto_kk'].";";
        $data.=$row['pendidikan'].";";
        $data.=$row['tanggal_pengeluaran_kk'].";";
        $data.=$row['tanggal_reg']."\n";
    }
    echo $data;
    exit();
}
?>