<?php
// koneksi ke database
require "config.php";

require "template/header.php";
?>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <?php
            // ambil halaman yang diinginkan
            $page = isset($_GET['page']) ? $_GET['page'] : "";
            $action = isset($_GET['action']) ? $_GET['action'] : "";

            // tampilkan halaman yang diinginkan
            if ($page == "") {
                include "Welcome.php";
            } elseif ($page == "alternatif") {
                if ($action == "") {
                    include "data/alternatif.php";
                } elseif ($action == "tambah") {
                    include "data/tambah_alternatif.php";
                } elseif ($action == "update") {
                    include "data/edit_alternatif.php";
                } else {
                    include "data/hapus_alternatif.php";
                }
            } elseif ($page == "kriteria") {
                if ($action == "") {
                    include "data/kriteria.php";
                } elseif ($action == "tambah") {
                    include "data/tambah_kriteria.php";
                } elseif ($action == "update") {
                    include "data/edit_kriteria.php";
                } else {
                    include "data/hapus_kriteria.php";
                }
            } elseif ($page == "matriks") {
                if ($action == "") {
                    include "matrik/matriks.php";
                } elseif ($action == "tambah") {
                    include "matrik/tambah_keputusan.php";
                } elseif ($action == "update") {
                    include "matrik/edit.php";
                } else {
                    include "matrik/hapus.php";
                }
            } elseif ($page == "normalisasi") {
                if ($action == "") {
                    include "normalisasi/normalisasi.php";
                }
            } elseif ($page == "hasil") {
                if ($action == "") {
                    include "hasil/hasil.php";
                }
            } else {
                include "welcome.php";
            }
            ?>

        </div>
        <!-- /. New Row -->
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark ">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

<?php
require "template/footer.php";
?>
