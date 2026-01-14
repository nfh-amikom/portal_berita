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

// Ambil data dulu untuk hapus gambar
$sqlGet = mysqli_query($config, "SELECT gambar FROM berita WHERE id = '$id'");
$data = mysqli_fetch_assoc($sqlGet);

if ($data) {
    // Hapus file gambar
    if (file_exists($data['gambar'])) {
        unlink($data['gambar']);
    }

    // Hapus berita
    mysqli_query($config, "DELETE FROM berita WHERE id = '$id'");
}

header("Location: index.php?hapus=1");
exit();
?>
