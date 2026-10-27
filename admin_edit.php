<?php
// Proteksi Session: Hanya bisa diakses jika sudah login
if (!isset($_SESSION['login_status']) || $_SESSION['login_status'] !== true) {
    echo "<script>alert('Akses ditolak! Silakan login terlebih dahulu.'); window.location='index.php?modul=login';</script>";
    exit;
}

$id = $_GET['id'] ?? '';
if (empty($id)) {
    echo "<script>window.location='index.php?modul=admin';</script>";
    exit;
}

// Ambil data admin berdasarkan ID
$query  = "SELECT * FROM admin_users WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$admin  = mysqli_fetch_assoc($result);

if (!$admin) {
    echo "<p style='color:red;'>Data admin tidak ditemukan.</p>";
    exit;
}

if (isset($_POST['update'])) {
    $username     = mysqli_real_escape_string($conn, $_POST['username']);
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $password_baru = mysqli_real_escape_string($conn, $_POST['password']);

    // Cek apakah username sudah dipakai admin lain (selain dirinya sendiri)
    $cek = mysqli_query($conn, "SELECT id FROM admin_users WHERE username = '$username' AND id != '$id'");
    if (mysqli_num_rows($cek) > 0) {
        $pesanError = "Username sudah digunakan oleh admin lain.";
    } else {
        // Jika field password diisi, update password; jika kosong, biarkan password lama
        if (!empty($password_baru)) {
            $updateQuery = "UPDATE admin_users SET username='$username', nama_lengkap='$nama_lengkap', password='$password_baru' WHERE id='$id'";
        } else {
            $updateQuery = "UPDATE admin_users SET username='$username', nama_lengkap='$nama_lengkap' WHERE id='$id'";
        }

        $update = mysqli_query($conn, $updateQuery);

        if ($update) {
            echo "<script>alert('Data admin berhasil diperbarui!'); window.location='index.php?modul=admin';</script>";
        } else {
            $pesanError = "Gagal memperbarui data: " . mysqli_error($conn);
        }
    }
}
?>

<h2 style="color:#2c3e50; margin-top:0;">Ubah Data Admin</h2>

<?php if (!empty($pesanError)): ?>
    <div style="background: #fadbd8; color: #900c3f; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
        <?php echo $pesanError; ?>
    </div>
<?php endif; ?>

<form action="" method="POST">
    <div style="margin-bottom: 12px;">
        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($admin['username']); ?>" required style="width: 100%; padding: 8px; box-sizing: border-box;">
    </div>
    <div style="margin-bottom: 12px;">
        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Nama Lengkap:</label>
        <input type="text" name="nama_lengkap" value="<?php echo htmlspecialchars($admin['nama_lengkap']); ?>" required style="width: 100%; padding: 8px; box-sizing: border-box;">
    </div>
    <div style="margin-bottom: 15px;">
        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Password Baru: <small style="color:#7f8c8d;">(Kosongkan jika tidak ingin mengubah password)</small></label>
        <input type="password" name="password" placeholder="Isi untuk mengganti password" style="width: 100%; padding: 8px; box-sizing: border-box;">
    </div>
    <button type="submit" name="update" style="background: #27ae60; color: white; padding: 10px 15px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Perbarui Data</button>
    <a href="index.php?modul=admin" style="margin-left: 10px; color: #7f8c8d; text-decoration: none;">Batal</a>
</form>
