<?php
$id = $_GET['id'] ?? '';

if (!empty($id)) {
    // Menjalankan query DELETE berdasarkan ID
    $query = "DELETE FROM biodata_mhs WHERE id = '$id'";
    $hapus = mysqli_query($conn, $query);

    if ($hapus) {
        echo "<script>alert('Data mahasiswa berhasil dihapus!'); window.location='index.php?modul=mahasiswa';</script>";
    } else {
        echo "<p style='color:red;'>Gagal menghapus data: " . mysqli_error($conn) . "</p>";
        echo "<br><a href='index.php?modul=mahasiswa'>Kembali ke Daftar Mahasiswa</a>";
    }
} else {
    // Jika tidak ada ID di URL, kembalikan ke halaman mahasiswa
    echo "<script>window.location='index.php?modul=mahasiswa';</script>";
}
