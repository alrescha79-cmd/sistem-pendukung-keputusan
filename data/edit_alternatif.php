<?php 

if(isset($_POST['update'])){
    $id = $_GET['id_alternatif'];
    $nama=$_POST['nama'];

    // validasi
    $sql = "SELECT*FROM alternatif WHERE nama_alternatif='$nama'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        ?>
<div class="alert alert-danger alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Nama Lokasi atau Alternatif Sudah Ada! Silakan Masukan Alternatif Lain.</strong>
</div>
<?php
    }else{
	// proses update
        $sql = "UPDATE alternatif SET nama_alternatif='$nama' WHERE id_alternatif='$id'";
        if ($conn->query($sql) === TRUE) {
            // echo "<script>alert('Data berhasil diupdate!');window.location.href='?page=alternatif';</script>";
            // header("Location:?page=alternatif");
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


// ambil data dari database
$id=$_GET['id_alternatif'];

$sql = "SELECT * FROM alternatif WHERE id_alternatif='$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<div class="row">
    <div class="col-sm-12">
        <form action="" method="POST">
            <div class="card border-dark">
                <div class="card card-dark">
                    <div class="card-header border-dark"><strong>Edit Alternatif atau
                            Lokasi</strong></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" value="<?php echo $row['nama_alternatif']; ?>"
                                name="nama" maxlength="100" required>
                        </div>

                        <input class="btn btn-success" type="submit" name="update" value="Update">
                        <a class="btn btn-outline-danger" href="?page=alternatif">Batal</a>

                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
