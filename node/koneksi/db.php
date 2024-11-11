<?php
// Koneksi database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'showroom';

// Buat koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Fungsi fetchData
function fetchData($conn, $query) {
    $result = mysqli_query($conn, $query);
    return $result ? $result : false;
}