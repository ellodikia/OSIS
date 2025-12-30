<?php

include '../koneksi.php';

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM galeri WHERE id='$id'");
header("Location: gallery.php");

?>