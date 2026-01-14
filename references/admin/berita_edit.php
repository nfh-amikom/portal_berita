<?php
session_start();
include "config.php";

// Must be logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php?error=notloggedin");
    exit();
}

// Must have ID
if (!isset($_GET['id'])) {
    header("Location: index.php?error=noid");
    exit();
}

$id = intval($_GET['id']);

// Get berita data
$queryBerita = mysqli_query($config, "SELECT * FROM berita WHERE id = $id");
$berita = mysqli_fetch_assoc($queryBerita);

// Get all kategori
$queryKategori = mysqli_query($config, "SELECT * FROM kategori");

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Berita</title>

    <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
</head>

<body>

    <!-- NAVBAR -->
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
            <h2 class="m-0">Ubah Berita</h2>
        </div>

        <div class="card shadow-sm p-4">

            <form action="berita_edit_action.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $berita['id']; ?>">

                <!-- Judul -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Judul Berita</label>
                    <input type="text" name="judul" class="form-control" 
                           value="<?= htmlspecialchars($berita['judul']); ?>" required>
                </div>

                <!-- Thumbnail -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Thumbnail Berita</label><br>

                    <img src="<?= htmlspecialchars($berita['gambar']); ?>" 
                         class="rounded mb-2" 
                         style="width: 180px; height:auto;">

                    <input type="file" name="gambar" class="form-control mt-2" accept=".jpg, .jpeg, .png">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
                </div>

                <!-- Tanggal -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" style="max-width:250px"
                           value="<?= htmlspecialchars($berita['tanggal']); ?>" required>
                </div>

                <!-- Kategori -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Kategori Berita</label>

                    <?php while ($kategori = mysqli_fetch_assoc($queryKategori)) { ?>
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="radio" 
                                   name="id_kategori" 
                                   value="<?= $kategori['id'] ?>"
                                   <?= ($kategori['id'] == $berita['id_kategori']) ? 'checked' : '' ?>
                                   required>

                            <label class="form-check-label">
                                <?= $kategori['nama']; ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>

                <!-- Isi -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Isi Berita</label>
                    <textarea id="summernote" name="isidata"><?= htmlspecialchars($berita['isi']); ?></textarea>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="index.php" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>

        </div>
    </div>

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
        });
    </script>

</body>

</html>
