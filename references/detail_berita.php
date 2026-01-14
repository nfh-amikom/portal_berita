<?php
include "admin/config.php";

// Take berita  id and redirect if null
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

// Query data berita
$sql = "
    SELECT b.*, k.nama AS kategori, u.username AS penulis
    FROM berita b
    LEFT JOIN kategori k ON b.id_kategori = k.id
    LEFT JOIN users u ON b.id_user = u.id
    WHERE b.id = $id
";
$result = mysqli_query($config, $sql);
$berita = mysqli_fetch_assoc($result);

if (!$berita) {
    echo "<p>Berita tidak ditemukan.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($berita['judul']); ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        .isi-berita img {
            max-width: 100%;
            border-radius: 6px;
        }
    </style>
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-light bg-white shadow-sm px-3">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="admin/assets/logo.png" alt="Logo" style="height:40px;">
            <span class="ms-2 fw-bold fs-4 text-success">News Frontier House</span>
        </a>

        <div class="d-flex gap-4">
            <a href="#" class="text-decoration-none text-dark">Tentang Kami</a>
            <a href="#" class="text-decoration-none text-dark">Partner</a>
            <a href="#" class="text-decoration-none text-dark">Lamar Pekerjaan</a>
        </div>
    </div>
</nav>

<div class="container shadow-sm pt-5 pb-5 bg-white">

    <!-- Judul -->
    <h1 class="fw-bold mb-2"><?= htmlspecialchars($berita['judul']); ?></h1>

    <!-- Tanggal + kategori + penulis -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3" style="font-size: 15px;">

        <!-- Left: kategori + tanggal -->
        <div class="text-muted">
            <?= htmlspecialchars($berita['kategori']); ?> •
            <?= htmlspecialchars($berita['tanggal']); ?>
        </div>

        <!-- Right: username + icon -->
        <div class="d-flex align-items-center text-muted">
            <img src="admin/assets/person_icon.png" 
                alt="Author" 
                style="height:20px; width:20px; object-fit:contain;" 
                class="me-2">
            <span><?= htmlspecialchars($berita['penulis']); ?></span>
        </div>
    </div>

    <!-- Thumbnail -->
    <img src="images/<?= htmlspecialchars($berita['gambar']); ?>"
         class="w-100 rounded mb-4"
         style="max-height: 450px; object-fit: cover;">

    <!-- Isi Berita -->
    <div class="isi-berita fs-5">
        <?= $berita['isi']; ?>  <!-- htmlspecialchars(), sorry I don't need you anymore -->
    </div>

</div>

</body>
</html>
