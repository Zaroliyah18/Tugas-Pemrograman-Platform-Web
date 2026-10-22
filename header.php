<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Website Dinamis & Autentikasi Session</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        header {
            background: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .user-info {
            margin-top: 8px;
            font-size: 14px;
            color: #1abc9c;
        }

        nav {
            background: #34495e;
            padding: 10px;
            text-align: center;
        }

        nav a {
            color: white;
            margin: 0 12px;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            color: #1abc9c;
            text-decoration: underline;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            min-height: 250px;
        }

        footer {
            text-align: center;
            padding: 15px;
            background: #2c3e50;
            color: white;
            margin-top: 40px;
            font-size: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }
    </style>
</head>

<body>

    <header>
        <h1 style="margin:0;">Portal Akademik Kampus Nusantara</h1>

        <!-- Menampilkan informasi user jika session login masih aktif -->
        <?php if (isset($_SESSION['login_status']) && $_SESSION['login_status'] === true): ?>
            <div class="user-info">
                Halo, <strong><?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?></strong>
                (<em><?php echo htmlspecialchars($_SESSION['username']); ?></em>) | Status: <span style="color: #2ecc71;">Aktif</span>
            </div>
        <?php endif; ?>
    </header>

    <nav>
        <a href="index.php?modul=beranda">Beranda</a>
        <a href="index.php?modul=profil">Profil Kampus</a>
        <a href="index.php?modul=mahasiswa">Data Mahasiswa (CRUD)</a>
        <a href="index.php?modul=kontak">Kontak</a>

        <!-- Pergantian Tombol Login/Logout -->
        <?php if (isset($_SESSION['login_status'])): ?>
            <a href="index.php?modul=logout" style="color: #e74c3c;" onclick="return confirm('Keluar dari sistem?');">Logout</a>
        <?php else: ?>
            <a href="index.php?modul=login" style="color: #f1c40f;">Login Admin</a>
        <?php endif; ?>
    </nav>

    <div class="container">