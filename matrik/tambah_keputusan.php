<?php
if (isset($_POST['simpan'])) {
    $alternatif = $_POST['id_alternatif'];

    // cek jika data sudah ada sebelumnya
    $sqlCheckData = "SELECT COUNT(*) AS dataCount FROM normalisasi WHERE id_alternatif = '$alternatif'";
    $resultCheckData = $conn->query($sqlCheckData);
    $rowCheckData = $resultCheckData->fetch_assoc();
    $dataCount = intval($rowCheckData['dataCount']);

    if ($dataCount > 0) {
        // jika data sudah ada, tampilkan pesan error
        echo "<div class='alert alert-danger alert-dismissible fade show'>
        <button type='button' class='close' data-dismiss='alert'>&times;</button>
        <strong>Nilai Lokasi atau Alternatif Sudah Ada! Silakan Masukan Nilai Alternatif Lain.</strong>
    </div>";
    } else {
        // jika data belum ada, simpan data ke tabel normalisasi
        foreach ($_POST['nilai'] as $kriteriaId => $nilai) {
            // konversi nilai ke integer dan float
            $kriteriaId = intval($kriteriaId);
            $nilai = floatval($nilai);

            // Proses simpan ke tabel normalisasi
            $sql = "INSERT INTO normalisasi VALUES (NULL, '$kriteriaId', '$alternatif', '$nilai')";
            $conn->query($sql);
        }

        // echo "<script>alert('Data berhasil disimpan!');window.location.href='?page=matriks';</script>";
        // header("Location: ?page=matriks");
        echo "
            <div class='alert alert-success alert-dismissible fade show'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Data berhasil disimpan!</strong>
            </div>
            ";
            echo "<meta http-equiv='refresh' content='1;url=?page=matriks'>";
    }
}
?>

<div class="row">
    <div class="col-sm-12">
        <form action="" method="POST">
            <div class="card border-dark">
                <div class="card card-dark">
                    <div class="card-header  border-dark"><strong>Tambah Nilai Alternatif atau
                            Lokasi</strong></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Alternatif</label>
                            <select class="form-control chosen" data-placeholder="Pilih Alternatif: "
                                name="id_alternatif">
                                <option value=""></option>;
                                <?php
                                // Menampilkan nama-nama alternatif
                                $sql = "SELECT * FROM alternatif";
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                <option value="<?php echo $row['id_alternatif']; ?>">
                                    <?php echo $row['nama_alternatif']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kriteria</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Menampilkan nama-nama kriteria
                                $sql = "SELECT * FROM kriteria";
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                <tr>
                                    <td><?php echo $row['nama_kriteria']; ?></td>
                                    <td>
                                        <input type="text" class="form-control"
                                            name="nilai[<?php echo $row['id_kriteria']; ?>]" maxlength="100" required>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>

                        <input class="btn btn-success" type="submit" name="simpan" value="Simpan">
                        <a class="btn btn-outline-danger" href="?page=matriks">Batal</a>

                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
