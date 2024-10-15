<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "macrostore";

$koneksi = new mysqli($host, $username, $password, $database);
if (mysqli_connect_errno()) {
    trigger_error("Koneksi Gagal: " . mysqli_connect_errno(), E_USER_ERROR);
}
