<?php
// Proteksi Session: Hanya bisa diakses jika sudah login
if (!isset($_SESSION['login_status']) || $_SESSION['login_status'] !== true) {
    echo "<script>alert('Akses ditolak! Silakan login terlebih dahulu.'); window.location='index.php?modul=login';</script>";
    exit;
}

$id = $_GET['id'] ?? '';

if (!empty($id)) {
    // Cegah admin menghapus akunnya sendiri yang sedang aktif
    $query  = "SELECT username FROM admin_users WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $target = mysqli_fetch_assoc($result);

    if ($target && $target['username'] === $_SESSION['username']) {
        echo "<script>alert('Tidak bisa menghapus akun yang sedang aktif digunakan!'); window.location='index.php?modul=admin';</script>";
        exit;
    }

    // Menjalankan query DELETE berdasarkan ID
    $hapus = mysqli_query($conn, "DELETE FROM admin_users WHERE id = '$id'");

    if ($hapus) {
        echo "<script>alert('Data admin berhasil dihapus!'); window.location='index.php?modul=admin';</script>";
    } else {
        echo "<p style='color:red;'>Gagal menghapus data: " . mysqli_error($conn) . "</p>";
        echo "<br><a href='index.php?modul=admin'>Kembali ke Kelola Admin</a>";
    }
} else {
    // Jika tidak ada ID di URL, kembalikan ke halaman admin
    echo "<script>window.location='index.php?modul=admin';</script>";
}
