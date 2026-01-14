<?php
    $config =  mysqli_connect('localhost', 'root', '', 'database_0213');
    if (!$config) {
        die('Gagal terhubung ke MySQLi :' . mysqli_connect_error());
    }
?>