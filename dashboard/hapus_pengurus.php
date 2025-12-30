<?php

include '../koneksi.php';

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM pengurus WHERE id='$id'");
header("Location: pengurus.php");

?>