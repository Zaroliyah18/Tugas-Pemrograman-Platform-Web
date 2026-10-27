<?php
// Proteksi Session: Hanya bisa diakses jika sudah login
if (!isset($_SESSION['login_status']) || $_SESSION['login_status'] !== true) {
    echo "<script>alert('Akses ditolak! Silakan login terlebih dahulu.'); window.location='index.php?modul=login';</script>";
    exit;
}

// Mengambil semua data admin dari tabel admin_users
$query = "SELECT id, username, nama_lengkap FROM admin_users ORDER BY id ASC";
$result = mysqli_query($conn, $query);

$listAdmin = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $listAdmin[] = $row;
    }
} else {
    echo "<p style='color:red;'>Gagal memuat data dari database: " . mysqli_error($conn) . "</p>";
}
?>

<h2 style="color:#2c3e50; margin-top:0;">Kelola Data Admin (CRUD)</h2>
<p>Berikut adalah daftar akun administrator yang memiliki akses ke sistem.</p>

<a href="index.php?modul=admin_tambah" style="background: #27ae60; color: white; padding: 8px 12px; text-decoration: none; border-radius: 4px; font-weight: bold; display: inline-block; margin-bottom: 15px;">+ Tambah Admin Baru</a>

<table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <tr style="background-color: #f2f2f2;">
        <th>No</th>
        <th>Username</th>
        <th>Nama Lengkap</th>
        <th style="text-align: center;">Aksi</th>
    </tr>
    <?php if (!empty($listAdmin)): ?>
        <?php $no = 1;
        foreach ($listAdmin as $a): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><strong><?php echo htmlspecialchars($a['username']); ?></strong></td>
                <td><?php echo htmlspecialchars($a['nama_lengkap']); ?></td>
                <td style="text-align: center;">
                    <a href="index.php?modul=admin_edit&id=<?php echo $a['id']; ?>" style="color: #2980b9; text-decoration: none; font-weight: bold; margin-right: 10px;">Edit</a>
                    <a href="index.php?modul=admin_hapus&id=<?php echo $a['id']; ?>" style="color: #c0392b; text-decoration: none; font-weight: bold;" onclick="return confirm('Yakin ingin menghapus admin ini?');">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4" style="text-align:center; color:red;">Belum ada data admin di database.</td>
        </tr>
    <?php endif; ?>
</table>
