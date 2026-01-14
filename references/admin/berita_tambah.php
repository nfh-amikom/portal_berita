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
    <script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
    <script type="text/javascript" src="cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

</head>

<body>
    <?php
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $queryKategori = mysqli_query($config, "SELECT * FROM kategori");
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
                <h2 class="m-0">Tambah Berita</h2>
            </div>

            <div class="card shadow-sm p-4">
                <form action="berita_tambah_action.php" method="POST" enctype="multipart/form-data">

                    <!-- Judul -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Berita</label>
                        <input type="text" name="judul" class="form-control" placeholder="Masukkan judul berita" required>
                    </div>

                    <!-- Gambar -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Thumbnail Berita</label>
                        <input type="file" name="gambar" class="form-control" accept=".jpg, .jpeg, .png" required>
                    </div>

                    <!-- Tanggal -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal</label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="date" name="tanggal" id="tanggalInput" class="form-control" style="max-width: 250px;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="tanggalHariIni" name="tanggalHariIni">
                                <label class="form-check-label" for="tanggalHariIni">
                                    Gunakan tanggal hari ini
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Kategori (Radio) -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori Berita</label>

                        <?php while ($kategori = mysqli_fetch_assoc($queryKategori)) { ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="id_kategori" value="<?= $kategori['id'] ?>" required>
                                <label class="form-check-label">
                                    <?= $kategori['nama'] ?>
                                </label>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- Isi Berita (Summernote) -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Isi Berita</label>
                        <textarea id="summernote" name="isidata"></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="index.php" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
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

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Tulis isi berita di sini...',
                tabsize: 2,
                height: 250,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                ]
            });

            // Auto-disable tanggal if checkbox checked
            $('#tanggalHariIni').on('change', function() {
                const today = new Date().toISOString().split('T')[0];

                if (this.checked) {
                    $('#tanggalInput').val(today);
                    $('#tanggalInput').prop('disabled', true);
                } else {
                    $('#tanggalInput').prop('disabled', false);
                    $('#tanggalInput').val('');
                }
            });
        });
    </script>
</body>

</html>