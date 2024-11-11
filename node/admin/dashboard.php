<?php
include '../koneksi/db.php';

session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Ambil total pengguna
$total_pengguna_query = "SELECT COUNT(*) AS total FROM pengguna";
$total_pengguna_result = $conn->query($total_pengguna_query);
$total_pengguna = $total_pengguna_result->fetch_assoc()['total'];

// Ambil total kendaraan
$total_kendaraan_query = "SELECT COUNT(*) AS total FROM kendaraan";
$total_kendaraan_result = $conn->query($total_kendaraan_query);
$total_kendaraan = $total_kendaraan_result->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../assets/styles/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php include '../assets/component/navbar_admin.php'; ?>

    <!-- Hero Section -->
    <div class="hero">
        <div class="overlay"></div>
        <div class="hero-slider">
            <div class="slide active" style="background-image: url('../assets/img/Shelby.jpg');"></div>
            <div class="slide" style="background-image: url('../assets/img/Volkswagen.jpg');"></div>
            <div class="slide" style="background-image: url('../assets/img/1967-ford-mustang.jpeg');"></div>
        </div>
        <div class="hero-text">
            <h1>Selamat Datang Admin</h1>
        </div>
    </div>

    <!-- Main Content Section (Dashboard) -->
    <div class="main-content">
        <h1>Dashboard</h1>
        <div class="dashboard-cards">
            <div class="card">
                <i class="fas fa-users"></i>
                <h3>Total Pengguna</h3>
                <p><?php echo $total_pengguna; ?></p>
            </div>
            <div class="card">
                <i class="fas fa-car"></i>
                <h3>Total Kendaraan</h3>
                <p><?php echo $total_kendaraan; ?></p>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$conn->close(); // Tutup koneksi database
?>
