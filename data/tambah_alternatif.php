<?php
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];

    // validasi
    $sql = "SELECT * FROM alternatif WHERE nama_alternatif='$nama'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
?>
<!-- jika data sudah ada -->
<div class="alert alert-danger alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Nama Lokasi atau Alternatif Sudah Ada! Silakan Masukan Alternatif Lain.</strong>
</div>
<?php
    } else {
        //jika data belum ada proses simpan
        $sql = "INSERT INTO alternatif VALUES (NULL, '$nama')";
        if ($conn->query($sql) === TRUE) {
            // tampilkan alert "Data berhasil disimpan!" di atas form tambah
            echo "
            <div class='alert alert-success alert-dismissible fade show'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Data berhasil disimpan!</strong>
            </div>
            ";
            echo "<meta http-equiv='refresh' content='1;url=?page=alternatif'>";
        }
    }
}
?>


<div class="row">
    <div class="col-sm-12">
        <form action="" method="POST">
            <div class="card border-dark">
                <div class="card card-dark">
                    <div class="card-header border-dark"><strong>Tambah Lokasi atau
                            Alternatif</strong></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama Alternatif</label>
                            <input type="text" class="form-control" name="nama" maxlength="100" required>
                        </div>

                        <input class="btn btn-success" type="submit" name="simpan" value="Simpan">
                        <a class="btn btn-outline-danger" href="?page=alternatif">Batal</a>

                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
