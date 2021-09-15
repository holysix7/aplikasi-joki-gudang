<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard')?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-cloud-meatball"></i>
        </div>
        <div class="sidebar-brand-text mx-3">RAMEN AA </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url('dashboard')?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <!-- <div class="sidebar-heading">
        Master Data
    </div> -->

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Master Data</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Master Data:</h6>
                <a class="collapse-item" href="<?= base_url('admin/akun')?>">Akun</a>
                <a class="collapse-item" href="<?= base_url('admin/supplier')?>">Supplier</a>
                <a class="collapse-item" href="<?= base_url('admin/pelanggan')?>">Pelanggan</a>
                <a class="collapse-item" href="<?= base_url('admin/tables')?>">Meja</a>
                <a class="collapse-item" href="<?= base_url('admin/menu')?>">Menu</a>
                <a class="collapse-item" href="<?= base_url('admin/level/pedas')?>">Level Pedas</a>
                <a class="collapse-item" href="<?= base_url('admin/gudang')?>">Gudang</a>
                <a class="collapse-item" href="<?= base_url('admin/kuah')?>">Kuah</a>
                <?php if($this->session->userdata('role') == 'superadmin'){ ?>
                <a class="collapse-item" href="<?= base_url('admin/karyawan')?>">Karyawan</a>
                <?php } ?>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Transaksi</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Transaksi:</h6>
                <a class="collapse-item" href="<?= base_url("transaksi/pembelian") ?>">Pembelian</a>
                <a class="collapse-item" href="<?= base_url("transaksi/penjualan") ?>">Penjualan</a>
                <a class="collapse-item" href="<?= base_url("transaksi/persediaan") ?>">Persediaan</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    <?php if($this->session->userdata('role') != 'karyawan'){ ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
            aria-expanded="true" aria-controls="collapseThree">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Laporan</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Jurnal:</h6>
                <a class="collapse-item" href="<?= base_url("laporan/jurnal") ?>">Jurnal</a>
                <a class="collapse-item" href="<?= base_url("laporan/buku-besar") ?>">Buku Besar</a>
                <!-- <a class="collapse-item nav-link collapsed" href="#" id="navbardrop" data-toggle="dropdown">
                    Buku Besar
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?= base_url('laporan/buku-besar/kas') ?>">Kas </a>
                    <a class="dropdown-item" href="<?= base_url('laporan/buku-besar/persediaan') ?>">Persediaan Stok Gudang </a>
                    <a class="dropdown-item" href="<?= base_url('laporan/buku-besar/penjualan') ?>">Penjualan </a>
                    <a class="dropdown-item" href="<?= base_url('laporan/buku-besar/harga-pokok-penjualan') ?>">Harga Pokok Penjualan </a>
                </div> -->
                <a class="collapse-item" href="<?= base_url("laporan/pembelian") ?>">Laporan Pembelian</a>
                <a class="collapse-item" href="<?= base_url("laporan/penjualan") ?>">Laporan Penjualan</a>
                <a class="collapse-item" href="<?= base_url("laporan/persediaan") ?>">Laporan Persediaan</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <?php } ?>

</ul>