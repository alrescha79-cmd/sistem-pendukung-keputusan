<div class="card card-dark">
    <div class="card-header border-dark"><strong>Tabel Matriks Ternormalisasi</strong></div>
    <div class="card-body">
        <table class="table table-bordered" id="myTable">
            <thead>
                <tr>
                    <th>Alternatif</th>
                    <?php
                    $sql = "SELECT * FROM kriteria";
                    $result = $conn->query($sql);
                    $maxValues = array(); // Array untuk menyimpan nilai maksimum untuk setiap kriteria
                    $minValues = array(); // Array untuk menyimpan nilai minimum untuk setiap kriteria
                    while ($row = $result->fetch_assoc()) {
                        ?>
                    <th><?php echo $row['nama_kriteria'] ?></th>
                    <?php
                        $kriteriaId = $row['id_kriteria'];
                        // mendapatkan nilai minimum dan maksimum untuk setiap kriteria
                        $sqlMinMax = "SELECT MIN(nilai) AS cost, MAX(nilai) AS benefit FROM normalisasi WHERE id_kriteria = '$kriteriaId'";
                        $resultMinMax = $conn->query($sqlMinMax);
                        $rowMinMax = $resultMinMax->fetch_assoc();
                        $minValues[$kriteriaId] = $rowMinMax['cost'];
                        $maxValues[$kriteriaId] = $rowMinMax['benefit'];
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menampilkan nilai-nilai alternatif
                $sqlAlternatif = "SELECT DISTINCT alternatif.nama_alternatif as alt FROM alternatif";
                $resultAlternatif = $conn->query($sqlAlternatif);
                while ($rowAlternatif = $resultAlternatif->fetch_assoc()) {
                    ?>
                <tr>
                    <td>
                        <?php echo $rowAlternatif['alt']; ?>
                    </td>
                    <?php
                        // Menampilkan nilai-nilai kriteria untuk setiap alternatif
                        $sqlKriteria = "SELECT kriteria.id_kriteria as krt, kriteria.atribut as atribut, normalisasi.nilai as nilai 
                            FROM kriteria 
                            LEFT JOIN normalisasi ON kriteria.id_kriteria = normalisasi.id_kriteria 
                            AND normalisasi.id_alternatif = (
                              SELECT id_alternatif 
                              FROM alternatif 
                              WHERE nama_alternatif = '{$rowAlternatif['alt']}' 
                              LIMIT 1
                            )";
                        $resultKriteria = $conn->query($sqlKriteria);
                        while ($rowKriteria = $resultKriteria->fetch_assoc()) {
                            $kriteriaId = $rowKriteria['krt'];
                            $nilai = $rowKriteria['nilai'];
                            $tipe = $rowKriteria['atribut'];

                            // Melakukan perhitungan normalisasi untuk mendapatkan matriks nilai ternormalisasi
                            if ($tipe == 'cost' && $nilai != 0) {
                                $normalisasi = $minValues[$kriteriaId] / $nilai;
                            } elseif ($tipe == 'benefit' && $maxValues[$kriteriaId] != 0) {
                                $normalisasi = $nilai / $maxValues[$kriteriaId];
                            } else {
                                $normalisasi = 0; // Handle division by zero
                            }
                            // 3 digit setelah koma
                            $normalisasi = round($normalisasi, 3);
                            ?>
                    <td><?php echo $normalisasi; ?></td>
                    <?php } ?>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- keterangan -->
<div class="card card-dark mt-5">
    <div class="card-header">
        <h5 class="card-title">Matriks Ternormalisasi</h5>
    </div>
    <div class="card-body">
        <p class="card-text text-justify mx-4">Melakukan perhitungan normalisasi untuk mendapatkan matriks nilai
            ternormalisasi, dengan ketentuan : Untuk normalisasi nilai, jika faktor/attribute kriteria bertipe <b>Cost</b> maka
            digunakan rumusan: <b>Rij = ( min{Xij} / Xij) </b> sedangkan jika faktor/attribute kriteria bertipe <b>Benefit</b>
            maka digunakan rumusan: <b>Rij = ( Xij/max{Xij}</b> ).
        </p>
    </div>
</div>
