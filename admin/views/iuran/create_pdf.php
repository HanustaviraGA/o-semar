<?php
require('fpdf.php');
$pdf=new FPDF('P','mm',array(100,100));
$pdf->AddPage();

include ('../../koneksi.php');
$id = $_GET['id'];
$sql = "SELECT * FROM tagihan WHERE id_tagihan='$id'";
$result = mysqli_query($koneksi, $sql);
$identifikasi = mysqli_fetch_array($result);
// Cek Nama
$cek_nik = $identifikasi['nik'];
$nama = "SELECT nama, alamat FROM penduduk WHERE nik='$cek_nik'";
$result_nama = mysqli_query($koneksi, $nama);
$identifikasi_nama = mysqli_fetch_array($result_nama);

$nomor = $identifikasi['id_tagihan'];
$nama = $identifikasi_nama['nama'];
$alamat = $identifikasi_nama['alamat'];
$total = $identifikasi['total_tagihan'];
$jenis = $identifikasi['jenis_tagihan'];
$status = $identifikasi['status_pembayaran'];
$rekening = $identifikasi['rekening'];

$pdf->SetFont('Arial','B',7);
$pdf->Cell( 0, 3, 'Surat Pembayaran', 0, 0, 'C');
$pdf->Ln(7);
$pdf->Cell( 0, 3, 'Nomor : '. $nomor, 0, 0, 'C');
$pdf->Ln(7);
$pdf->Cell( 0, 3, 'Nama : '. $nama, 0, 0, 'J');
$pdf->Ln(3);
$pdf->Cell( 0, 3, 'Alamat : '. $alamat, 0, 0, 'J');
$pdf->Ln(3);
$pdf->Cell( 0, 3, 'Sejumlah : Rp.'. $total, 0, 0, 'J');
$pdf->Ln(7);
$pdf->Cell( 0, 3, 'Pembayaran ini diperuntukkan sebagai', 0, 0, 'C');
$pdf->Ln(3);
$pdf->Cell( 0, 3, 'Tagihan '.$jenis, 0, 0, 'C');
$pdf->Ln(7);
$pdf->Cell( 0, 3, 'Status Pembayaran', 0, 0, 'C');
if($status == 'Unpaid'){
    $tanggal = $identifikasi['jatuh_tempo'];
    $month = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $tanggal_hari = (int)date('d', strtotime($identifikasi['jatuh_tempo']));
    $bulan_hari = $month[((int)date('m', strtotime($identifikasi['jatuh_tempo']))) - 1];
    $tahun_hari = (int)date('Y', strtotime($identifikasi['jatuh_tempo']));
    $pdf->Ln(3);
    $pdf->Cell( 0, 3, 'Belum Terbayar', 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->Cell( 0, 3, 'Segera Lakukan Pembayaran Ke Rekening BCA-'.$rekening, 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->Cell( 0, 3, 'Sebelum Tanggal '.$tanggal_hari.' '.$bulan_hari.' '.$tahun_hari, 0, 0, 'C');
    $pdf->Ln(7);
    $pdf->Cell( 0, 3, 'Bendahara Desa', 0, 0, 'C');
    $pdf->Ln(9);
    $pdf->Cell( 0, 3, 'Sujatmiko', 0, 0, 'C');
    // File
    $date = date('Y-m-d');
    $filename=$id.'_'.$cek_nik.'.pdf';
    $pdf->Output('F', 'berkas/' . $filename, true);
    $pdf->Output();
    // Masuk daftar lampiran
    $lampiran = "INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran)
    VALUES ('$cek_nik', '$id', '$filename', 'Pembayaran Tagihan', '$date', '$status', '-')";
    $exec_lampiran = mysqli_query($koneksi, $lampiran);
    
}else if($status == 'Paid'){
    $tanggal = $identifikasi['tanggal_pembayaran'];
    $month = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $tanggal_hari = (int)date('d', strtotime($identifikasi['tanggal_pembayaran']));
    $bulan_hari = $month[((int)date('m', strtotime($identifikasi['tanggal_pembayaran']))) - 1];
    $tahun_hari = (int)date('Y', strtotime($identifikasi['tanggal_pembayaran']));
    $pdf->Ln(3);
    $pdf->Cell( 0, 3, 'Lunas', 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->Cell( 0, 3, 'Dibayar tanggal '.$tanggal_hari.' '.$bulan_hari.' '.$tahun_hari, 0, 0, 'C');
    $pdf->Ln(11);
    $pdf->Cell( 0, 3, 'Bendahara Desa', 0, 0, 'C');
    $pdf->Ln(10);
    $pdf->Cell( 0, 3, 'Sujatmiko', 0, 0, 'C');
    // File
    $date = date('Y-m-d');
    $filename=$id.'_'.$cek_nik.'.pdf';
    $pdf->Output('F', 'berkas/' . $filename, true);
    $pdf->Output();
    // Masuk daftar lampiran
    $lampiran = "INSERT INTO lampiran(nik, kode, lampiran, jenis_lampiran, tanggal_lampiran, status_lampiran, ket_lampiran)
    VALUES ('$cek_nik', '$id', '$filename', 'Pembayaran Tagihan', '$date', '$status', '-')";
    $exec_lampiran = mysqli_query($koneksi, $lampiran);
}

?>