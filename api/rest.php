<?php

require_once "../koneksi.php";
require_once "../csrf.php";
require_once "./query.php";
require_once "./generate_response.php";
require_once "./route/get_berkas.php";
require_once "./route/get_penduduk_data.php";
require_once "./route/register.php";
require_once "./route/login.php";
require_once "./route/logout.php";
require_once "./route/lihat_kk.php";
require_once "./route/lihat_daftar_surat.php";
require_once "./route/lihat_daftar_laporan.php";
require_once "./route/lihat_daftar_lampiran_by_id.php";
require_once "./route/lihat_iuran.php";
require_once "./route/lihat_jenis_surat.php";
require_once "./route/lihat_pengumuman.php";
require_once "./route/buat_surat.php";
require_once "./route/buat_laporan.php";
require_once "./route/update_iuran.php";
require_once "./route/update_profile.php";

/**
 * API Key dihapus karena tidak terlalu
 * berguna untuk melindungi API
 * 
 * Dialihkan dengan mengecek session user
 */