<?php
session_start();
include("config.php");

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT username FROM users
        WHERE username='$username' 
        AND password='$password'";

$hasil = mysqli_query($config, $sql) or exit("Error query : <b>" . $sql . "</b>.");

if (mysqli_num_rows($hasil) > 0) {
    $data = mysqli_fetch_array($hasil);
    $_SESSION['username'] = $data['username'];
    header("Location:index.php");
    exit();
} else {
    header("Location:index.php?error=1");
    exit();
}
?>