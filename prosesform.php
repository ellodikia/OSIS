<?php
$pesan = "";

if (isset($_POST['daftar'])) {
    $nama_tim = mysqli_real_escape_string($koneksi, $_POST['nama_tim']);
    $cek_tim = mysqli_query($koneksi, "SELECT nama_tim FROM formulir WHERE nama_tim = '$nama_tim'");

    if (mysqli_num_rows($cek_tim) > 0) {
        $pesan = "<div class='bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4'>
                    Gagal! Nama tim <b>$nama_tim</b> sudah terdaftar. Gunakan nama lain.
                  </div>";
    } else {
        $unit = $_POST['unit'];
        $kelas_jurusan = $_POST['kelas_jurusan'];
        $nama_peserta = $_POST['nama_peserta'];
        $perlombaan = $_POST['perlombaan'];

        $query = "INSERT INTO formulir (unit, kelas_jurusan, nama_tim, nama_peserta, perlombaan) 
                  VALUES ('$unit', '$kelas_jurusan', '$nama_tim', '$nama_peserta', '$perlombaan')";
        
        if (mysqli_query($koneksi, $query)) {
            $pesan = "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4'>Pendaftaran Berhasil!</div>";
        }
    }
}
?>