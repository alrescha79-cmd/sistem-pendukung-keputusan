<?php
ob_start();
// koneksi ke database
require "config.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SPK | SAW</title>
    <link rel="shortcut icon" href="assets/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/datatables.min.css">
    <link rel="stylesheet" href="assets/css/all.css">
    <link rel="stylesheet" href="assets/css/bootstrap-chosen.css">
    <link rel="stylesheet" href="assets/css/bootstrap-utilities.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&family=Poppins:wght@400;600&display=swap"
        rel="stylesheet">

    <style>
    .table tr td {
        width: 20px;
    }

    #sidenav {
        position: fixed;
        top: 0;
        height: 100vh;
        overflow-y: hidden;
    }

    .content-wrapper {
        position: relative;
        top: 0;
        z-index: 1;
    }

    .modal-backdrop {
        z-index: 10;
        /* Make the backdrop one layer below the custom modal */
    }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand  sticky-top" style="backdrop-filter: blur(3px); height: 56px;">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto my-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <!-- <p class="text-dark-emphasis">Penentuan Pendirian Pabrik Baru</p> -->
                    <ol class="breadcrumb bg-transparent float-right ">
                        <li class="breadcrumb-item "><a href="index.php?page=home">Dashboard</a></li>
                        <li class="breadcrumb-item active"><?= $_GET['page'] ?></li>
                    </ol>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-dark elevation-4 " id="sidenav">

            <!-- Bootstrap Modal for dasboard berita Confirmation -->
            <div class="modal fade" id="beritaModal" tabindex="-1" role="dialog" aria-labelledby="beritaModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="beritaModalLabel">SPK | SAW </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h6 class="text-center">Apakah Anda yakin untuk meninggalkan halaman ini, dan beralih ke
                                halaman Dashboard Berita?</h6>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <a href="http://localhost/berita/admin/index.php?page=home"
                                class="btn btn-primary">Lanjutkan</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bootstrap Modal for delete alternatif Confirmation -->
            <div class="modal fade" id="deleteAlternatifModal" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="deleteAlternatifModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary-subtle">
                            <h1 class="modal-title fs-5 text-danger text-center" id="deleteAlternatifModalLabel"><span
                                    class="fas fa-exclamation-triangle"></span> Hapus Alternatif</h1>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h3 class="text-center">Apakah Anda Yakin untuk menghapus <b id="namaAlt"
                                    class="text-danger">Alternatif</b> ?</h3>
                            <p class="text-center text-danger" style="font-size: 11px;">Semua data dengan nama
                                Alternatif yang sama
                                akan hilang!</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-outline-danger" id="btnConfirmDeleteAlternatif">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Bootstrap Modal for delete kriteria Confirmation -->
            <div class="modal fade" id="deleteKriteriaModal" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="deleteKriteriaModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary-subtle">
                            <h1 class="modal-title fs-5 text-danger text-center" id="deleteKriteriaModalLabel"><span
                                    class="fas fa-exclamation-triangle"></span> Hapus Kriteria</h1>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h3 class="text-center">Apakah Anda Yakin untuk menghapus <b  id="namaKri"
                                    class="text-danger">Kriteria</b> ?</h3>
                            <p class="text-center text-danger" style="font-size: 11px;">Semua data dengan nama
                                Alternatif yang sama akan hilang!</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-outline-danger" id="btnConfirmDeleteKriteria">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Brand Logo -->
            <a href="#" class="brand-link ml-3" style="height: 56px;">
                <i class="fas fa-code nav-icon"></i>
                <span class="brand-text font-weight-bold">TA 2021-C</span>
            </a>


            <!-- Sidebar -->
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="assets/favicon.png" alt="User Image">
                    </div>
                    <div class="info">
                        <h3>SPK | SAW</h3>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2 sticky-top">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <li class="nav-item <?php echo ($_GET['page'] == 'welcome') ? 'menu-open' : ''; ?>">
                            <a href="?page=welcome"
                                class="nav-link <?php echo ($_GET['page'] == 'welcome') ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=alternatif"
                                class="nav-link <?php echo ($_GET['page'] == 'alternatif') ? 'active' : ''; ?>">
                                <i class="fas fa-map nav-icon"></i>
                                <p>Alternatif</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=kriteria"
                                class="nav-link <?php echo ($_GET['page'] == 'kriteria') ? 'active' : ''; ?>">
                                <i class="fas fa-weight nav-icon"></i>
                                <p>Bobot & Kriteria</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=matriks"
                                class="nav-link <?php echo ($_GET['page'] == 'matriks') ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-calculator"></i>
                                <p>Matriks</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=normalisasi"
                                class="nav-link <?php echo ($_GET['page'] == 'normalisasi') ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-book-reader"></i>
                                <p>Normalisasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=hasil"
                                class="nav-link <?php echo ($_GET['page'] == 'hasil') ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-list-ol"></i>
                                <p>Hasil</p>
                            </a>
                        </li>
                        <li class="nav-item" style="margin-top: 6rem;">
                            <a href="#" class="nav-link" data-toggle="modal" data-target="#beritaModal">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p><b>Dashboard Berita</b></p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
                <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->


</body>

</html>
