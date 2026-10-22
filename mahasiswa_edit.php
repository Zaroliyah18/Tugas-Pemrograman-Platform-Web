<?php
$id = $_GET['id'] ?? '';
if (empty($id)) {
    echo "<script>window.location='index.php?modul=mahasiswa';</script>";
    exit;
}

// Ambil data mahasiswa berdasarkan ID
$query = "SELECT * FROM biodata_mhs WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$mhs = mysqli_fetch_assoc($result);

if (!$mhs) {
    echo "<p style='color:red;'>Data mahasiswa tidak ditemukan.</p>";
    exit;
}

// Ambil daftar program studi untuk dropdown
$queryProdi = "SELECT * FROM prodi ORDER BY nama_prodi ASC";
$resultProdi = mysqli_query($conn, $queryProdi);

if (isset($_POST['update'])) {
    $nim = mysqli_real_escape_string($conn, $_POST['nim']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    // Menangkap prodi_id dari dropdown yang diubah
    $prodi_id = mysqli_real_escape_string($conn, $_POST['prodi_id']);
    $ipk = mysqli_real_escape_string($conn, $_POST['ipk']);

    // Update prodi_id di database
    $updateQuery = "UPDATE biodata_mhs SET nim='$nim', nama='$nama', prodi_id='$prodi_id', ipk='$ipk' WHERE id='$id'";
    $update = mysqli_query($conn, $updateQuery);

    if ($update) {
        echo "<script>alert('Data mahasiswa berhasil diperbarui!'); window.location='index.php?modul=mahasiswa';</script>";
    } else {
        echo "<p style='color:red;'>Gagal memperbarui data: " . mysqli_error($conn) . "</p>";
    }
}
?>

<h2 style="color:#2c3e50; margin-top:0;">Ubah Data Mahasiswa</h2>
<form action="" method="POST">
    <div style="margin-bottom: 12px;">
        <label style="display: block; font-weight: bold; margin-bottom: 5px;">NIM:</label>
        <input type="text" name="nim" value="<?php echo htmlspecialchars($mhs['nim']); ?>" required style="width: 100%; padding: 8px; box-sizing: border-box;">
    </div>
    <div style="margin-bottom: 12px;">
        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Nama Lengkap:</label>
        <input type="text" name="nama" value="<?php echo htmlspecialchars($mhs['nama']); ?>" required style="width: 100%; padding: 8px; box-sizing: border-box;">
    </div>

    <div style="margin-bottom: 12px;">
        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Program Studi:</label>
        <!-- Dropdown pilihan prodi dengan menyeleksi data lama -->
        <select name="prodi_id" required style="width: 100%; padding: 8px; box-sizing: border-box;">
            <option value="">-- Pilih Program Studi --</option>
            <?php while ($p = mysqli_fetch_assoc($resultProdi)): ?>
                <option value="<?php echo $p['id']; ?>" <?php echo ($mhs['prodi_id'] == $p['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($p['nama_prodi']); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div style="margin-bottom: 15px;">
        <label style="display: block; font-weight: bold; margin-bottom: 5px;">IPK:</label>
        <input type="number" step="0.01" max="4.00" min="0.00" name="ipk" value="<?php echo $mhs['ipk']; ?>" required style="width: 100%; padding: 8px; box-sizing: border-box;">
    </div>
    <button type="submit" name="update" style="background: #27ae60; color: white; padding: 10px 15px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Perbarui Data</button>
    <a href="index.php?modul=mahasiswa" style="margin-left: 10px; color: #7f8c8d; text-decoration: none;">Batal</a>
</form>