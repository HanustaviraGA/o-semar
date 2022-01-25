    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <?php if($_SESSION["keadaan"] == "sudah_login_admin") {
    ?>  
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../../index">
      <div class="sidebar-brand-icon">
        <img src="../../assets/img/o-semar2.png">
      </div>
      <div class="sidebar-brand-text mx-3">O-Semar Admin</div>
    </a>
    <?php
    } else if($_SESSION["keadaan"] == "sudah_login_penduduk"){
    ?>  
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../../index">
      <div class="sidebar-brand-icon">
        <img src="../../assets/img/o-semar2.png">
      </div>
      <div class="sidebar-brand-text mx-3">O-Semar</div>
    </a>
    <?php
    } else if ($_SESSION["keadaan"] == "sudah_login_rt") {
    ?>
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../../index">
      <div class="sidebar-brand-icon">
        <img src="../../assets/img/o-semar2.png">
      </div>
      <div class="sidebar-brand-text mx-3">O-Semar RT</div>
    </a>
    <?php
    } else if ($_SESSION["keadaan"] == "sudah_login_rw") {
    ?>
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../../index">
      <div class="sidebar-brand-icon">
        <img src="../../assets/img/o-semar2.png">
      </div>
      <div class="sidebar-brand-text mx-3">O-Semar RW</div>
    </a>
    <?php
    }
    ?>
      <hr class="sidebar-divider my-0">
      <li class="nav-item active">
        <a class="nav-link" href="../../index">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Layanan
      </div>
      <li class="nav-item">
        <a class="nav-link" href="../../surat/index">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Pengajuan Surat</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../iuran/index">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Pembayaran Iuran</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../laporan/index">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Pelaporan</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../adminduk/kartu_keluarga/index">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Kartu Keluarga</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../pengumuman/index">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Pengumuman Warga</span>
        </a>
      </li>
      <?php if($_SESSION["keadaan"] == "sudah_login_rt" || $_SESSION["keadaan"] == "sudah_login_rw" || $_SESSION['keadaan'] == "sudah_login_admin") { ?>
      <li class="nav-item">
        <a class="nav-link" href="../../adminduk/list_penduduk/index">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Daftar Penduduk</span>
        </a>
      </li>
      <?php } else if($_SESSION["keadaan"] == "sudah_login_penduduk") { ?>

      <?php } ?>
      <?php if($_SESSION["keadaan"] == "sudah_login_admin") {
      ?>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Administrator
      </div>
      <li class="nav-item">
        <a class="nav-link" href="../../super/pengaturan">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Pengaturan Wilayah</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../super/list_rt">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Pengaturan RT</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../super/list_rw">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Pengaturan RW</span>
        </a>
      </li>
      
      <hr class="sidebar-divider">
      <div class="version" id="version-O-Semar"></div>
    <?php
    } else if ($_SESSION["keadaan"] == "sudah_login_rt" || $_SESSION["keadaan"] == "sudah_login_rw" || $_SESSION['keadaan'] == "sudah_login_penduduk") {
    ?>
      
    <?php
    }
    ?>
    </ul>
    <!-- Sidebar -->