<?php

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $bobot = $_POST['bobot'];
    $atribut = $_POST['atribut'];

    //proses simpan
    $sql = "INSERT INTO kriteria VALUES (NULL, '$nama', '$bobot', '$atribut')";
    if ($conn->query($sql) === TRUE) {
        // echo "<script>alert('Data berhasil disimpan!');window.location.href='?page=kriteria';</script>";
        // header("Location: ?page=kriteria");
        echo "
            <div class='alert alert-success alert-dismissible fade show'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Data berhasil disimpan!</strong>
            </div>
            ";
            echo "<meta http-equiv='refresh' content='1;url=?page=kriteria'>";
    }
}
?>


<div class="row">
    <div class="col-sm-12">
        <form action="" method="POST">
            <div class="card border-dark">
                <div class="card card-dark">
                    <div class="card-header border-dark"><strong>Tambah Bobot dan
                            Kriteria</strong></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="nama" maxlength="100" required>
                            <label for="">Bobot</label>
                            <small class="text-danger font-italic" style="font-size: 10px;"> <b>*</b> Format bobot harus
                                menggunakan
                                tanda
                                titik
                                (.)
                                sebagai pemisah desimal.</small>
                            <input type="text" class="form-control" name="bobot" maxlength="100" required>
                            <label for="">Atribut</label>
                            <select class="form-control chosen" data-placeholder="" name="atribut">
                                <option value="" disabled selected>Pilih Atribut:</option>
                                <?php
                                // query dari enum
                                $sql = "SHOW COLUMNS FROM kriteria WHERE Field = 'atribut'";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                $enum = str_replace("enum('", "", $row['Type']);
                                $enum = str_replace("')", "", $enum);
                                $enum = explode("','", $enum);
                                foreach ($enum as $value) {
                                    echo "<option value='$value'>$value</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <input class="btn btn-success" type="submit" name="simpan" value="Simpan">
                        <a class="btn btn-outline-danger" href="?page=kriteria">Batal</a>

                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
