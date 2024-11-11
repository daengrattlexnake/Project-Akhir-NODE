<?php
session_start();
?>

<nav class="navbar">
    <div class="logo">
        <a href="index.php">
            <img src="assets/img/LOGO.png" alt="Logo" class="logo-img">
        </a>
    </div>
    <ul class="nav-links">
        <li><a href="index.php">Beranda</a></li>
        <li><a href="katalog.php">Katalog</a></li>

        <?php if (isset($_SESSION['username'])): ?>
            <li><a href="auth/logout.php">Keluar</a></li>
            <li><a href="profil.php"><?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
        <?php else: ?>
            <li><a href="auth/masuk.php">Masuk</a></li>
            <li><a href="auth/daftar.php">Daftar</a></li>
        <?php endif; ?>
    </ul>
</nav>
