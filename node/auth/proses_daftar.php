<?php
include '../koneksi/db.php'; // Menyertakan file koneksi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password

    // Query untuk memasukkan data ke tabel pengguna
    $sql = "INSERT INTO pengguna (nama, email, password, Role, status_pengguna) VALUES ('$username', '$email', '$password', 'user', 'aktif')";

    if ($conn->query($sql) === TRUE) {
        echo "Pendaftaran berhasil!";
        header("Location: masuk.php"); // Redirect ke halaman login
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
