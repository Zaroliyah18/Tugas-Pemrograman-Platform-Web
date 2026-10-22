<?php
// Mengambil data secara langsung dari tabel database menggunakan MySQLi
// Menggunakan LEFT JOIN untuk mengambil nama_prodi dari tabel prodi berdasarkan relasi prodi_id
$query = "SELECT biodata_mhs.*, prodi.nama_prodi 
          FROM biodata_mhs 
          LEFT JOIN prodi ON biodata_mhs.prodi_id = prodi.id 
          ORDER BY biodata_mhs.id DESC";
$result = mysqli_query($conn, $query);

$listMhs = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $listMhs[] = $row;
    }
} else {
    echo "<p style='color:red;'>Gagal memuat data dari database: " . mysqli_error($conn) . "</p>";
}
?>

<h2 style="color:#2c3e50; margin-top:0;">Daftar Mahasiswa Aktif (CRUD)</h2>
<p>Berikut adalah data mahasiswa yang dikelola secara penuh melalui operasi database MySQLi dengan relasi tabel.</p>

<a href="index.php?modul=mahasiswa_tambah" style="background: #27ae60; color: white; padding: 8px 12px; text-decoration: none; border-radius: 4px; font-weight: bold; display: inline-block; margin-bottom: 15px;">+ Tambah Mahasiswa Baru</a>

<table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <tr style="background-color: #f2f2f2;">
        <th>No</th>
        <th>NIM</th>
        <th>Nama Lengkap</th>
        <th>Program Studi</th>
        <th>IPK</th>
        <th style="text-align: center;">Aksi</th>
    </tr>
    <?php if (!empty($listMhs)): ?>
        <?php $no = 1;
        foreach ($listMhs as $m): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><strong><?php echo htmlspecialchars($m['nim']); ?></strong></td>
                <td><?php echo htmlspecialchars($m['nama']); ?></td>
                <td>
                    <?php
                    // Menampilkan nama prodi dari tabel relasi, jika kosong tampilkan pesan default
                    echo !empty($m['nama_prodi']) ? htmlspecialchars($m['nama_prodi']) : '<em>Belum diatur</em>';
                    ?>
                </td>
                <td><?php echo $m['ipk']; ?></td>
                <td style="text-align: center;">
                    <a href="index.php?modul=mahasiswa_edit&id=<?php echo $m['id']; ?>" style="color: #2980b9; text-decoration: none; font-weight: bold; margin-right: 10px;">Edit</a>
                    <a href="index.php?modul=mahasiswa_hapus&id=<?php echo $m['id']; ?>" style="color: #c0392b; text-decoration: none; font-weight: bold;" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6" style="text-align:center; color:red;">Belum ada rekaman data mahasiswa di database.</td>
        </tr>
    <?php endif; ?>
</table>