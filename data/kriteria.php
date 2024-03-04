<div class="card card-dark">
    <div class="card-header  border-dark"><strong>Tabel Bobot dan Kriteria</strong></div>
    <div class="card-body">
        <?php
        $sql = "SELECT SUM(bobot) AS total FROM kriteria";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total = $row['total'];
        $total = number_format($total, 2);
        // if ($total > 1) {
        //     echo "<div class='alert alert-danger'>Total bobot tidak boleh melebihi 1</div>";
        // }
        ?>
        <a class="btn btn-success mb-2" href="?page=kriteria&action=tambah"><i class="fas fa-folder-plus"></i> Tambah</a>
        <table class="table table-bordered" id="myTable">
            <thead>
                <tr>
                    <th width="50px">No</th>
                    <th width="50px">Simbol</th>
                    <th width="250px">Nama</th>
                    <th width="80px">Bobot</th>
                    <th width="80px">Atribut</th>
                    <th width="50px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 0;
                $sql = "SELECT*FROM kriteria";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td class="dt-center font-weight-bold"><?php echo (++$no); ?></td>
                    <td><?php echo "C". ($no) ?></td>
                    <td><?php echo $row['nama_kriteria']; ?></td>
                    <td><?php echo $row['bobot']; ?></td>
                    <td><?php echo $row['atribut']; ?></td>
                    <td class="dt-center">
                        <a class="btn btn-dark mb-1"
                            href="?page=kriteria&action=update&id_kriteria=<?php echo $row['id_kriteria']; ?>">
                            <span class="fas fa-edit"></span>
                        </a>
                        <!-- <a onclick="return confirm('Yakin menghapus data ini ?')" class="btn btn-danger mx-4 my-1"
                            href="?page=kriteria&action=hapus&   id_kriteria=<?php echo $row['id_kriteria']; ?>">
                            <span class="fas fa-trash"></span>
                        </a> -->
                        <button type="button" class="btn btn-danger btn-delete" data-bs-toggle="modal"
                            data-bs-target="#deleteKriteriaModal" data-id="<?php echo $row['id_kriteria']; ?>"
                            data-name="<?php echo $row['nama_kriteria']; ?>">
                            <span class="fas fa-trash"></span>
                        </button>
                    </td>
                </tr>
                <?php
                    }
                    $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card mt-5">
    <div class="card-header bg-dark">
        <h5 class="card-title">Bobot dan Kriteria</h5>
    </div>
    <div class="card-body">
        <p class="card-text text-justify mx-4">Pengambil keputusan memberi bobot preferensi dari setiap kriteria dengan
            masing-masing jenisnya (Cost atau Benefit). Dengan total bobot preferensi tidak boleh melebihi <b>1</b>.</p>
    </div>
</div>
