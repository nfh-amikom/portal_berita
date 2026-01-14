<?php
session_start();
include "config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    ?>
        <nav class="navbar navbar-light bg-white shadow-sm px-3 mb-4">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="assets/logo.png" alt="Logo" style="height:40px;">
                </a>
                <div class="d-flex align-items-center gap-3">
                    <span class="fw-semibold">Halo, <?= htmlspecialchars($username); ?></span>
                    <a href="logout.php" class="btn btn-danger"><b>Logout</b></a>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="m-0">Daftar Berita</h2>
                <a href="berita_tambah.php" class="btn btn-primary">+ Tambah Berita</a>
            </div>

            <div class="card shadow-sm p-4">
                <?php
                $query = "SELECT * FROM berita ORDER BY tanggal DESC";
                $result = mysqli_query($config, $query);

                if (mysqli_num_rows($result) === 0): ?>
                    <p class="text-center text-muted">Belum ada berita.</p>

                    <?php else:
                    while ($berita = mysqli_fetch_assoc($result)):
                    ?>

                        <div class="d-flex align-items-center border rounded p-3 mb-3">
                            <!-- Thumbnail -->
                            <img src="<?= htmlspecialchars($berita['gambar']); ?>"
                                alt="Thumbnail"
                                class="rounded"
                                style="width: 120px; height: 80px; object-fit: cover;">

                            <?php
                            // Convert HTML → plain text 
                            $previewText = strip_tags($berita['isi']);

                            // Cut it to 80 chars
                            $previewText = substr($previewText, 0, 80) . "...";
                            ?>

                            <!-- Text info -->
                            <div class="ms-3 flex-grow-1">
                                <h5 class="mb-1"><?= htmlspecialchars($berita['judul']); ?></h5>
                                <small class="text-muted"><?= htmlspecialchars($berita['tanggal']); ?></small>
                                <p class="mb-0 mt-1 text-secondary" style="font-size: 14px;">
                                    <?= htmlspecialchars($previewText); ?>...
                                </p>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex flex-column align-items-end gap-2">
                                <a href="berita_edit.php?id=<?= $berita['id']; ?>" class="btn btn-sm btn-primary w-100">Edit</a>
                                <button
                                    class="btn btn-sm btn-danger w-100"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalHapus<?= $berita['id']; ?>">
                                    Hapus
                                </button>
                            </div>
                        </div>

                        <!-- Modal Konfirmasi Hapus -->
                        <div class="modal fade" id="modalHapus<?= $berita['id']; ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus berita:
                                        <strong><?= htmlspecialchars($berita['judul']); ?></strong>?
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>

                                        <a href="berita_hapus.php?id=<?= $berita['id']; ?>"
                                            class="btn btn-danger">
                                            Ya, Hapus
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                <?php
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    <?php
    } else {
    ?>
        <div class="bg-light d-flex align-items-center justify-content-center vh-100">
            <?php if (isset($_GET['error'])) { ?>
                <div class="toast-container position-fixed top-0 end-0 p-3">
                    <div class="toast show bg-danger text-white">
                        <div class="toast-header bg-danger text-white">
                            <strong class="me-auto">Login Error</strong>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                        </div>
                        <div class="toast-body">
                            Username / password salah.
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="card shadow-lg p-4" style="width: 350px; border-radius: 1rem;">
                <div class="text-center mb-4">
                    <img src="assets/logo.png" alt="Logo" class="img-fluid mb-2" style="max-width: 120px;">
                    <h4 class="fw-semibold">Login</h4>
                </div>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    <?php
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>