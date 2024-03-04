<?php

$id=$_GET['id_kriteria'];

$sql = "DELETE FROM kriteria WHERE id_kriteria='$id'";
if ($conn->query($sql) === TRUE) {
    // echo "<script>alert('Data berhasil dihapus!');window.location.href='?page=kriteria';</script>";
    // header("Location:?page=kriteria");
    echo "
            <div class='alert alert-success alert-dismissible fade show'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Data berhasil dihapus!</strong>
            </div>
            ";
            echo "<meta http-equiv='refresh' content='1;url=?page=kriteria'>";
}
$conn->close();
