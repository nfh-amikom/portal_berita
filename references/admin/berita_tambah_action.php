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

// Get form fields
$judul       = $_POST['judul'];
// $isi         = $_POST['isidata'];
$isi   = mysqli_real_escape_string($config, $_POST['isidata']); // Workaround for hidden escape chars
$id_kategori = $_POST['id_kategori'];
$useToday    = isset($_POST['tanggalHariIni']);
$tanggal     = $_POST['tanggal'];

// If checked, use today's tanggal
if ($useToday) {
    $tanggal = date("Y-m-d");
}

// Upload to images in root folder"
$targetDir = "../images/";  
$namaFile   = basename($_FILES["gambar"]["name"]);
$targetFile = $targetDir . time() . "_" . $namaFile;

move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFile);

// Insert berita
$sql = "INSERT INTO berita (id_user, id_kategori, judul, tanggal, isi, gambar)
        VALUES ('$id_user', '$id_kategori', '$judul', '$tanggal', '$isi', '$targetFile')";

$hasil = mysqli_query($config, $sql);

// Redirect after success
header("Location: index.php?sukses=1");
exit();

?>
