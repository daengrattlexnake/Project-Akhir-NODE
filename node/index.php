
<?php

session_start(); // Memulai sesi

// Cek apakah pengguna sudah login
$isLoggedIn = isset($_SESSION['user_id']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
?>
<?php
if (isset($_GET['message'])) {
    echo "
    <script>
        Swal.fire({
            title: 'Sukses',
            text: '" . htmlspecialchars($_GET['message']) . "',
            icon: 'success',
            confirmButtonColor: 'var(--teal)'
        });
    </script>
    ";
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Showroom Node</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/main.css">
    
</head>
<body>

<?php include 'assets/component/navbar.php'; ?>


    <!-- Search Popup -->
    <div class="popup" id="popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">×</span>
            <h2>Car Catalog</h2>
            <!-- Add catalog content here -->
        </div>
    </div>

    <!-- Hero Section -->
    <div class="hero">
        <div class="overlay"></div>
        <div class="hero-slider">
            <div class="slide active" style="background-image: url('assets/img/Shelby.jpg');"></div>
            <div class="slide" style="background-image: url('assets/img/Volkswagen.jpg');"></div>
            <div class="slide" style="background-image: url('assets/img/1967-ford-mustang.jpeg');"></div>
        </div>
        <div class="hero-text">
            <h1>Selamat Datang <?php echo htmlspecialchars($username); ?></h1>
            <p>Rasakan koleksi mobil terbaik, mulai dari klasik vintage hingga modern yang memukau.</p>        </div>
    </div>

<!-- Highlight Section -->
<section class="highlight">
    <h2>Mobil Unggulan</h2>
    <div class="highlight-content">
        <div class="highlight-slider">
            <div class="highlight-slide active" style="background-image: url('assets/img/1965\ Ford\ Falcon.jpeg');"></div>
            <div class="highlight-slide" style="background-image: url('assets/img/Chevrolet\ Camaro\ \(1969\).jpeg');"></div>
            <div class="highlight-slide" style="background-image: url('assets/img/Porsche\ 911\ \(1964\).jpg');"></div>
            <button class="prev" onclick="changeHighlightSlide(-1)">&#10094;</button>
            <button class="next" onclick="changeHighlightSlide(1)">&#10095;</button>
        </div>
        <div class="highlight-text">
            <p>Mobil-mobil unggulan kami hadir untuk memberikan pengalaman berkendara premium bagi Anda. Dengan desain menawan dan spesifikasi kelas atas, setiap mobil dalam katalog ini menjanjikan performa dan kenyamanan terbaik di kelasnya</p>
            <button class="button-primary">Tampilkan Lebih Banyak</button>
        </div>
    </div>
    </section>

    <!-- Team Section -->
    <section class="team">
        <h2>TIM KAMI</h2>
        <div class="team-cards">
            <div class="card">
                <img src="assets/img/orang_gantenk.jpg" alt="Team Anggota">
                <div class="card-info">
                    <h3>Anggota 1</h3>
                </div>
            </div>
            <div class="card">
                <img src="assets/img/pakdeajg.jpg" alt="Team Anggota">
                <div class="card-info">
                    <h3>Anggota 2</h3>
                </div>
            </div>
            <div class="card">
                <img src="assets/img/ketua.jpg" alt="KETUA">
                <div class="card-info">
                    <h3>Ketua</h3>
                </div>
            </div>
            <div class="card">
                <img src="assets/img/nabila.jpg" alt="Team Anggota">
                <div class="card-info">
                    <h3>Anggota 3</h3>
                </div>
            </div>
                        <div class="card">
                <img src="assets/img/anggota 4.jpg" alt="Team Anggota">
                <div class="card-info">
                    <h3>Anggota 4</h3>
                </div>
            </div>
            <!-- Add other team Anggotas here -->
        </div>
    </section>

    <!-- Footer -->
 <?php include "assets/component/footer.php"?>
</body>
<script src="assets/scripts/script.js"></script>
</html>
