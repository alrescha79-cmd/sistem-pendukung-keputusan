<?php

if (isset($_POST['simpan'])) {
    $alternatif = $_POST['id_alternatif'];

    // Proses menyimpan nilai alternatif
    foreach ($_POST['nilai'] as $kriteriaId => $nilai) {
        // Convert the values to integer and float
        $kriteriaId = intval($kriteriaId);
        $nilai = floatval($nilai);

        // Prepare the UPDATE statement
        $stmt = $conn->prepare("UPDATE normalisasi SET nilai = ? WHERE id_alternatif = ? AND id_kriteria = ?");
        $stmt->bind_param("dii", $nilai, $alternatif, $kriteriaId);// Bind the parameters

        // Execute the UPDATE query
        $stmt->execute();
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
    exit();
}

// Get the alternative ID from the URL parameter
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $kriteriaData = array();

    // mengambil nilai alternatif dari database
    $sqlKriteria = "SELECT id_kriteria, nilai FROM normalisasi WHERE id_alternatif = ?";
    $stmt = $conn->prepare($sqlKriteria);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultKriteria = $stmt->get_result();

    while ($rowKriteria = $resultKriteria->fetch_assoc()) {
        $kriteriaData[$rowKriteria['id_kriteria']] = $rowKriteria['nilai'];
    }

    // mengambil nama alternatif dari database
    $sqlAlternative = "SELECT nama_alternatif FROM alternatif WHERE id_alternatif = ?";
    $stmt = $conn->prepare($sqlAlternative);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultAlternative = $stmt->get_result();
    $alternativeName = $resultAlternative->fetch_assoc()['nama_alternatif'];

    // Get all criteria from the database
    $sql = "SELECT * FROM kriteria";
    $result = $conn->query($sql);
}
?>

<div class="row">
    <div class="col-sm-12">
        <form action="" method="POST">
            <div class="card border-dark">
                <div class="card card-dark">
                    <div class="card-header border-dark">
                        <strong>Ubah Nilai Alternatif atau Lokasi</strong>
                    </div>
                    <div class="card-body">
                        <?php if (isset($id)) { ?>
                        <input type="text" readonly class="form-control mb-2" name=""
                            value="<?php echo $alternativeName; ?>">
                        <input type="hidden" name="id_alternatif" value="<?php echo $id; ?>">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kriteria</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['nama_kriteria']; ?></td>
                                    <td>
                                        <input type="text" class="form-control"
                                            name="nilai[<?php echo $row['id_kriteria']; ?>]" maxlength="100"
                                            value="<?php echo isset($kriteriaData[$row['id_kriteria']]) ? $kriteriaData[$row['id_kriteria']] : ''; ?>"
                                            required>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <input class="btn btn-success" type="submit" name="simpan" value="Simpan">
                        <a class="btn btn-outline-danger" href="?page=matriks">Batal</a>
                        <?php } else { ?>
                        <p>Invalid request. Please provide the 'id' parameter.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
