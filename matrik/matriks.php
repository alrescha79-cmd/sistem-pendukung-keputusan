<div class="card card-dark">
    <div class="card-header  border-dark"><strong>Tabel Matriks Keputusan</strong></div>
    <div class="card-body">
        <a class="btn btn-success mb-2" href="?page=matriks&action=tambah"> <i class="fas fa-calendar-plus"></i> Isi Nilai
            Alternatif</a>
        <table class="table table-bordered" id="myTable">
            <thead>
                <tr>
                    <th>Alternatif</th>
                    <?php
                    // Menampilkan nama-nama kriteria
                    $sql = "SELECT * FROM kriteria";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                    ?>
                    <th><?php echo $row['nama_kriteria'] ?></th>
                    <?php } ?>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menampilkan nilai-nilai alternatif
                $sqlAlternatif = "SELECT DISTINCT alternatif.id_alternatif, alternatif.nama_alternatif as alt FROM alternatif";
                $resultAlternatif = $conn->query($sqlAlternatif);
                while ($rowAlternatif = $resultAlternatif->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $rowAlternatif['alt']; ?></td>
                    <?php
                        // Menampilkan nilai-nilai kriteria untuk setiap alternatif
                        $sqlKriteria = "SELECT kriteria.id_kriteria as krt, normalisasi.nilai as nilai 
                            FROM kriteria 
                            LEFT JOIN normalisasi ON kriteria.id_kriteria = normalisasi.id_kriteria 
                            AND normalisasi.id_alternatif = '{$rowAlternatif['id_alternatif']}'";
                        $resultKriteria = $conn->query($sqlKriteria);
                        while ($rowKriteria = $resultKriteria->fetch_assoc()) {
                        ?>
                    <td><?php echo $rowKriteria['nilai']; ?></td>
                    <?php } ?>
                    <td class="dt-center">
                        <a class="btn btn-dark"
                            href="?page=matriks&action=update&id=<?php echo $rowAlternatif['id_alternatif']; ?>">
                            <span class="fas fa-edit"></span>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<p class="text-info small">Notes : Jika ingin menghapus nilai alternatif bisa menghapus <b>Nama Alternatif</b> pada
    halaman <a href="?page=alternatif">Alternatif</a></p>

<div class="card card-dark mt-5">
    <div class="card-header ">
        <h5 class="card-title">Matriks Keputusan</h5>
    </div>
    <div class="card-body">
        <p class="card-text text-justify mx-4">Pengambil keputusan memberi nilai kriteria pada masing-masing alternatif.
        </p>
    </div>
</div>
