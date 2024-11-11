<?php
include '../koneksi/db.php'; // Menyertakan file koneksi

// Proses pendaftaran
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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link rel="stylesheet" href="../assets/styles/daftar.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="modal">
        <div class="modal-content">
            <h2>DAFTAR AKUN</h2>
            <form action="" method="POST">
    <div class="input-box">
        <label for="username"><i class="fas fa-user"></i> Nama Pengguna</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div class="input-box">
        <label for="email"><i class="fas fa-envelope"></i> Email</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="input-box">
        <label for="password"><i class="fas fa-lock"></i> Kata Sandi</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="btn">DAFTAR</button>
    <p>Sudah Punya Akun? <a href="masuk.php">Masuk</a></p>
</form>

        </div>
    </div>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script> 
</body>
</html>
