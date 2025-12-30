<?php

include '../koneksi.php';

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM kegiatan WHERE id='$id'");
header("Location: kalender.php");

?>