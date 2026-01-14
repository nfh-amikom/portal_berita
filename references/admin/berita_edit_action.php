<?php
session_start();
include "config.php";

// Must be logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php?error=notloggedin");
    exit();
}

// Get id_user based on logged in username
$username = $_SESSION['username'];
$sqlUser = "SELECT id FROM users WHERE username = '$username'";
$resultUser = mysqli_query($config, $sqlUser);
$userData = mysqli_fetch_assoc($resultUser);

$id_user = $userData['id'];

// Must have berita ID
if (!isset($_POST['id'])) {
    header("Location: index.php?error=noid");
    exit();
}

$id = $_POST['id'];

// Get form fields
$judul       = $_POST['judul'];
// $isi         = $_POST['isidata'];
$isi   = mysqli_real_escape_string($config, $_POST['isidata']); // Workaround for hidden escape chars
$id_kategori = $_POST['id_kategori'];
$useToday    = isset($_POST['tanggalHariIni']);
$tanggal     = $_POST['tanggal'];

// If "tanggal hari ini" checked, override
if ($useToday) {
    $tanggal = date("Y-m-d");
}

// Fetch old berita (to keep old image if not replaced)
$sqlOld = "SELECT gambar FROM berita WHERE id = '$id'";
$resultOld = mysqli_query($config, $sqlOld);
$oldData = mysqli_fetch_assoc($resultOld);

$oldImage = $oldData['gambar'];

// Handle image upload
$newImage = $oldImage; // default: keep old

if (!empty($_FILES["gambar"]["name"])) {

    $targetDir = "../images/";
    $namaFile = basename($_FILES["gambar"]["name"]);
    $targetFile = $targetDir . time() . "_" . $namaFile;

    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFile)) {
        $newImage = $targetFile;

        // Optionally delete old image if it's not empty
        if (!empty($oldImage) && file_exists($oldImage)) {
            unlink($oldImage);
        }
    }
}

// Update berita
$sql = "UPDATE berita SET 
            id_user     = '$id_user',
            id_kategori = '$id_kategori',
            judul       = '$judul',
            tanggal     = '$tanggal',
            isi         = '$isi',
            gambar      = '$newImage'
        WHERE id = '$id'";

$hasil = mysqli_query($config, $sql);

// Redirect after success
header("Location: index.php?edit_sukses=1");
exit();
?>
