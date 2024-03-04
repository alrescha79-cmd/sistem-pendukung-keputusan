<div class="card card-dark mb-5">
    <div class="card-header border-dark"><strong>Tabel Nilai Preferensi</strong></div>
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
          $criteriaWeights = array(); // Array untuk menyimpan bobot kriteria
          while ($row = $result->fetch_assoc()) {
            ?>
                    <th><?php echo $row['nama_kriteria'] ?></th>
                    <?php
            $kriteriaId = $row['id_kriteria'];
            // Dapatkan nilai minimum dan maksimum untuk kriteria saat ini
            $sqlMinMax = "SELECT MIN(nilai) AS cost, MAX(nilai) AS benefit FROM normalisasi WHERE id_kriteria = '$kriteriaId'";
            $resultMinMax = $conn->query($sqlMinMax);
            $rowMinMax = $resultMinMax->fetch_assoc();
            $minValues[$kriteriaId] = $rowMinMax['cost'];
            $maxValues[$kriteriaId] = $rowMinMax['benefit'];
            $criteriaWeights[$kriteriaId] = $row['bobot']; // Simpan bobot kriteria
          }
          ?>
                    <th>Nilai Preferensi</th>
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
            $preferenceValue = 0; // Inisialisasi nilai preferensi untuk setiap alternatif
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

              // Hitung normalisasinya untuk kriteria saat ini berdasarkan tipe atributnya (cost atau benefit) dan bobotnya (nilai)
              if ($tipe == 'cost' && $nilai != 0) {
                $normalization = $minValues[$kriteriaId] / $nilai;
              } elseif ($tipe == 'benefit' && $maxValues[$kriteriaId] != 0) {
                $normalization = $nilai / $maxValues[$kriteriaId];
              } else {
                $normalization = 0; // Handle division by zero
              }

              // Hitung nilai preferensi dengan mengalikan normalisasi dengan bobot kriteria 
              $preferenceCriteria = $normalization * $criteriaWeights[$kriteriaId];
              
              // Tambahkan nilai preferensi untuk kriteria ke nilai preferensi untuk alternatif 
              $preferenceValue += $preferenceCriteria;

              // 3 digit setelah koma
              $preferenceCriteria = round($preferenceCriteria, 3);
              $preferenceValue = round($preferenceValue, 3);
              ?>
                    <td><?php echo $preferenceCriteria; ?></td>
                    <?php } ?>
                    <td><?php echo $preferenceValue; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<!-- tabel preferensi end -->


<!-- tabel hasil -->
<div class="card card-dark mt-5">
    <div class="card-header border-dark d-flex justify-content-between">
        <div><strong>Hasil Perangkingan</strong></div>
        <div class="ml-auto">
            <a class="btn btn-outline-secondary" href="hasil/cetak.php" target="_blank">
                <span class="fas fa-print"></span> Cetak
            </a>
        </div>
    </div>


    <div class="card-body">
        <table class="table table-bordered" id="myTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Alternatif</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                <?php
        $no = 1;
        $preferenceValues = array(); // Array untuk menyimpan nilai preferensi untuk setiap alternatif
        $criteriaWeights = array(); // Array untuk menyimpan bobot kriteria
        $maxValues = array(); // Array untuk menyimpan nilai maksimum untuk setiap kriteria
        $minValues = array(); // Array untuk menyimpan nilai minimum untuk setiap kriteria

        $sql = "SELECT * FROM kriteria";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
          $kriteriaId = $row['id_kriteria'];
          $criteriaWeights[$kriteriaId] = $row['bobot']; //menyimpan bobot kriteria
          // mendapatkan nilai minimum dan maksimum untuk setiap kriteria 
          $sqlMinMax = "SELECT MIN(nilai) AS cost, MAX(nilai) AS benefit FROM normalisasi WHERE id_kriteria = '$kriteriaId'";
          $resultMinMax = $conn->query($sqlMinMax);
          $rowMinMax = $resultMinMax->fetch_assoc();
          $minValues[$kriteriaId] = $rowMinMax['cost'];
          $maxValues[$kriteriaId] = $rowMinMax['benefit'];
        }

        // Menampilkan nilai-nilai alternatif
        $sqlAlternatif = "SELECT DISTINCT alternatif.nama_alternatif as alt FROM alternatif";
        $resultAlternatif = $conn->query($sqlAlternatif);
        while ($rowAlternatif = $resultAlternatif->fetch_assoc()) {
          $preferenceValue = 0; // Inisialisasi nilai preferensi untuk setiap alternatif

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

            // Hitung normalisasinya untuk kriteria saat ini berdasarkan tipe atributnya (cost atau benefit) dan bobotnya (nilai) 
            if ($tipe == 'cost' && $nilai != 0) {
              $normalisasi = $minValues[$kriteriaId] / $nilai;
            } elseif ($tipe == 'benefit' && $maxValues[$kriteriaId] != 0) {
              $normalisasi = $nilai / $maxValues[$kriteriaId];
            } else {
              $normalisasi = 0; // Handle division by zero
            }

            // Hitung nilai preferensi dengan mengalikan normalisasi dengan bobot kriteria
            $preferenceValue += $normalisasi * $criteriaWeights[$kriteriaId];
          }

          // Simpan nilai preferensi dalam array asosiatif
          $preferenceValues[$rowAlternatif['alt']] = $preferenceValue;
        }

        // cek jika $preferenceValues array tidak kosong
        if (!empty($preferenceValues)) {
          // Sort the preference values array in descending order
          arsort($preferenceValues);

          // Tampilkan baris tabel sesuai urutan
          foreach ($preferenceValues as $alternatif => $hasil) {
            // 3 digit setelah koma
            $hasil = round($hasil, 3);
            ?>
                <tr>
                    <td class="font-weight-bold">
                        <?php echo $no++ . "."; ?>
                    </td>
                    <td>
                        <?php echo $alternatif; ?>
                    </td>
                    <td><?php echo $hasil; ?></td>
                </tr>
                <?php
          }
        } else {
          ?>
                <tr>
                    <td colspan="3" class="text-center">No data available</td>
                </tr>
                <?php
        }
        ?>
            </tbody>
        </table>
    </div>
</div>
<!-- tabel hasil end -->

<!-- keterangan -->
<div class="card card-dark mt-5">
    <div class="card-header">
        <h5 class="card-title">Nilai Preferensi dan Hasil</h5>
    </div>
    <div class="card-body">
        <p class="card-text text-justify mx-4">Nilai preferensi merupakan penjumlahan dari perkalian <b>nilai
                normalisasi
                dengan bobot kriteria</b>. Nilai preferensi digunakan untuk menentukan urutan prioritas dari alternatif
            yang
            ada. Semakin besar nilai preferensi, maka semakin baik alternatif tersebut.</p>
        </p>
    </div>
</div>
