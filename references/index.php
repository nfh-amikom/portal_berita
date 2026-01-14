<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    .berita-card {
        transition: 0.2s ease-in-out;
        cursor: pointer;
    }

    .berita-card:hover {
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.15) !important;
        /* shadow-lg */
        transform: translateY(-2px);
    }
</style>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-2">
        <div class="container">

            <!-- Left section: Logo + Text -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="admin/assets/logo.png" alt="Logo" style="height:40px;" class="me-2">
                <span class="ms-2 fw-bold fs-4 text-success">News Frontier House</span>
            </a>

            <!-- Toggler for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Right section: Menu -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="#">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="#">Partner</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="#">Lamar Pekerjaan</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="fw-bold mb-4">Berita Saat Ini</h2>

        <?php
        include "admin/config.php";

        $sql = "
            SELECT b.*, k.nama AS kategori 
            FROM berita b
            LEFT JOIN kategori k ON b.id_kategori = k.id
            ORDER BY b.tanggal DESC
        ";
        $result = mysqli_query($config, $sql);

        if (mysqli_num_rows($result) === 0): ?>

            <p class="text-muted">Belum ada berita.</p>

            <?php else:
            while ($b = mysqli_fetch_assoc($result)):
            ?>

                <a href="detail_berita.php?id=<?= $b['id']; ?>"
                    class="text-decoration-none text-dark">

                    <div class="card mb-4 shadow-sm border-0 berita-card">

                        <div class="d-flex p-3">

                            <!-- Thumbnail -->
                            <img src="images/<?= htmlspecialchars($b['gambar']); ?>"
                                class="rounded me-3"
                                style="width:180px; height:120px; object-fit:cover;">

                            <!-- Info -->
                            <div class="flex-grow-1">
                                <h5 class="fw-semibold mb-1">
                                    <?= htmlspecialchars($b['judul']); ?>
                                </h5>

                                <div class="text-muted mb-2" style="font-size:14px;">
                                    <?= htmlspecialchars($b['kategori']); ?> •
                                    <?= htmlspecialchars($b['tanggal']); ?>
                                </div>
                            </div>

                        </div>

                    </div>

                </a>

        <?php
            endwhile;
        endif;
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>