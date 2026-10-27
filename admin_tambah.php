<?php
// Proteksi Session: Hanya bisa diakses jika sudah login
if (!isset($_SESSION['login_status']) || $_SESSION['login_status'] !== true) {
    echo "<script>alert('Akses ditolak! Silakan login terlebih dahulu.'); window.location='index.php?modul=login';</script>";
    exit;
}

if (isset($_POST['submit'])) {
    $username     = mysqli_real_escape_string($conn, $_POST['username']);
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $password     = mysqli_real_escape_string($conn, $_POST['password']);

    // Cek apakah username sudah ada
    $cek = mysqli_query($conn, "SELECT id FROM admin_users WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        $pesanError = "Username sudah digunakan. Silakan pilih username lain.";
    } else {
        // Insert data admin baru ke database (password disimpan plain-text sesuai gaya proyek ini)
        $query  = "INSERT INTO admin_users (username, nama_lengkap, password) VALUES ('$username', '$nama_lengkap', '$password')";
        $insert = mysqli_query($conn, $query);

        if ($insert) {
            echo "<script>alert('Data admin berhasil ditambahkan!'); window.location='index.php?modul=admin';</script>";
        } else {
            $pesanError = "Gagal menambah data: " . mysqli_error($conn);
        }
    }
}
?>

<h2 style="color:#2c3e50; margin-top:0;">Tambah Admin Baru</h2>

<?php if (!empty($pesanError)): ?>
    <div style="background: #fadbd8; color: #900c3f; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
        <?php echo $pesanError; ?>
    </div>
<?php endif; ?>

<form action="" method="POST">
    <div style="margin-bottom: 12px;">
        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Username:</label>
        <input type="text" name="username" required style="width: 100%; padding: 8px; box-sizing: border-box;">
    </div>
    <div style="margin-bottom: 12px;">
        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Nama Lengkap:</label>
        <input type="text" name="nama_lengkap" required style="width: 100%; padding: 8px; box-sizing: border-box;">
    </div>
    <div style="margin-bottom: 15px;">
        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Password:</label>
        <input type="password" name="password" required style="width: 100%; padding: 8px; box-sizing: border-box;">
    </div>
    <button type="submit" name="submit" style="background: #2980b9; color: white; padding: 10px 15px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Simpan Data</button>
    <a href="index.php?modul=admin" style="margin-left: 10px; color: #7f8c8d; text-decoration: none;">Batal</a>
</form>
