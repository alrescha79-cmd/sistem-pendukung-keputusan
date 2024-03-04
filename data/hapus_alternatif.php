<?php

$id=$_GET['id_alternatif'];

$sql = "DELETE FROM alternatif WHERE id_alternatif='$id'";
if ($conn->query($sql) === TRUE) {
    // echo "<script>alert('Data berhasil dihapus!');window.location.href='?page=alternatif';</script>";
    // header("Location:?page=alternatif");
    echo "
            <div class='alert alert-success alert-dismissible fade show'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Data berhasil dihapus!</strong>
            </div>
            ";
            echo "<meta http-equiv='refresh' content='1;url=?page=alternatif'>";
}
$conn->close();
?>

