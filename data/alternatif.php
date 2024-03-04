<div class="card card-dark">
    <div class="card-header border-dark"><strong>Tabel Alternatif atau Lokasi</strong></div>
    <div class="card-body">
        <a class="btn btn-success mb-2" href="?page=alternatif&action=tambah"><i class="fas fa-plus-circle"></i> Tambah</a>
        <table class="table table-bordered" id="myTable">
            <thead>
                <tr>
                    <th width="50px">No</th>
                    <th width="250px">Nama</th>
                    <th width="50px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!--  proses menampilkan -->
                <?php
                $no = 1;
                $sql = "SELECT*FROM alternatif ORDER BY nama_alternatif ASC";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td class="dt-center font-weight-bold"><?php echo $no++; ?></td>
                    <td><?php echo $row['nama_alternatif']; ?></td>
                    <td class="dt-center">
                        <a class="btn btn-dark"
                            href="?page=alternatif&action=update&id_alternatif=<?php echo $row['id_alternatif']; ?>">
                            <span class="fas fa-edit"></span>
                        </a>
                        <!-- <a onclick="return confirm('Yakin menghapus data ini ?')" class="btn btn-danger"
                            href="?page=alternatif&action=hapus&id_alternatif=<?php echo $row['id_alternatif']; ?>">
                            <span class="fas fa-trash"></span>
                        </a> -->
                        <button type="button" class="btn btn-danger btn-delete" data-bs-toggle="modal"
                            data-bs-target="#deleteAlternatifModal" data-id="<?php echo $row['id_alternatif']; ?>"
                            data-name="<?php echo $row['nama_alternatif']; ?>">
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

<div class="card card-dark mt-5">
    <div class="card-header">
        <h5 class="card-title">Alternatif atau Lokasi</h5>
    </div>
    <div class="card-body">
        <p class="card-text text-justify mx-4">Berisi data nama Alternatif atau Lokasi calon tempat pembangunan pabrik
            baru.</p>
    </div>
</div>

