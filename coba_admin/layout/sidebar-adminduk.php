    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <?php if($_SESSION["keadaan"] == "sudah_login_admin") {
    ?>  
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
      <div class="sidebar-brand-icon">
        <img src="../../img/o-semar2.png">
      </div>
      <div class="sidebar-brand-text mx-3">O-Semar Admin</div>
    </a>
    <?php
    } else if($_SESSION["keadaan"] == "sudah_login_penduduk"){
    ?>  
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
      <div class="sidebar-brand-icon">
        <img src="../../img/o-semar2.png">
      </div>
      <div class="sidebar-brand-text mx-3">O-Semar</div>
    </a>
    <?php
    } else if ($_SESSION["keadaan"] == "sudah_login_rt") {
    ?>
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
      <div class="sidebar-brand-icon">
        <img src="../../img/o-semar2.png">
      </div>
      <div class="sidebar-brand-text mx-3">O-Semar RT</div>
    </a>
    <?php
    } else if ($_SESSION["keadaan"] == "sudah_login_rw") {
    ?>
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
      <div class="sidebar-brand-icon">
        <img src="../../img/o-semar2.png">
      </div>
      <div class="sidebar-brand-text mx-3">O-Semar RW</div>
    </a>
    <?php
    }
    ?>
      <hr class="sidebar-divider my-0">
      <li class="nav-item active">
        <a class="nav-link" href="../../index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Layanan
      </div>
      <li class="nav-item">
        <a class="nav-link" href="../../surat/index.php">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Pengajuan Surat</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../iuran/index.php">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Pembayaran Iuran</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../laporan/index.php">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Pelaporan</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../adminduk/kartu_keluarga/index.php">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Kartu Keluarga</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../adminduk/list_penduduk/index.php">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Daftar Penduduk</span>
        </a>
      </li>
      <?php if($_SESSION["keadaan"] == "sudah_login_admin") {
      ?>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Administrator
      </div>
      <li class="nav-item">
        <a class="nav-link" href="../../super/pengaturan.php">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Pengaturan Wilayah</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../super/list_rt.php">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Pengaturan RT</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../../super/list_rw.php">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Pengaturan RW</span>
        </a>
      </li>
      
      <hr class="sidebar-divider">
      <div class="version" id="version-ruangadmin"></div>
    <?php
    } else if ($_SESSION["keadaan"] == "sudah_login_rt" || $_SESSION["keadaan"] == "sudah_login_rw" || $_SESSION['keadaan'] == "suda_login_penduduk") {
    ?>
      
    <?php
    }
    ?>
    </ul>
    <!-- Sidebar -->