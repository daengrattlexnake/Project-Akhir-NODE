<?php
include '../koneksi/db.php';

// Menjaga agar halaman ini tidak diproses jika pengguna sudah login
session_start();
if (isset($_SESSION['user_id'])) {
    // Jika sudah login, arahkan ke halaman yang sesuai (admin atau index)
    if ($_SESSION['role'] === 'admin') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../index.php");
    }
    exit();
}

$alertMessage = '';
$alertIcon = '';
$alertTitle = '';
$alertText = '';
$redirectUrl = '';
$alertBackground = '';
$alertColor = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];  // Menggunakan email untuk login
    $password = $_POST['password'];

    // Menghindari SQL Injection dengan prepared statements
    $sql = "SELECT * FROM pengguna WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['ID_Pengguna'];
            $_SESSION['username'] = $row['nama'];
            $_SESSION['role'] = $row['Role'];

            // Set alert success
            $alertMessage = "Selamat datang, " . htmlspecialchars($row['nama']) . "!";
            $alertIcon = "success";
            $alertTitle = "Login Berhasil!";
            $alertText = '';
            $redirectUrl = ($_SESSION['role'] === 'admin') ? '../admin/dashboard.php' : '../index.php';

            // Menyesuaikan warna alert
            $alertBackground = 'var(--teal)'; // Teal untuk sukses
            $alertColor = 'var(--light-teal)'; // Light Teal untuk teks
        } else {
            // Set alert error for incorrect password
            $alertMessage = "Kata sandi salah!";
            $alertIcon = "error";
            $alertTitle = "Gagal Login";
            $alertText = '';

            // Menyesuaikan warna alert
            $alertBackground = 'var(--medium-dark)'; // Medium Dark untuk error
            $alertColor = 'var(--light-teal)'; // Light Teal untuk teks
        }
    } else {
        // Set alert error for user not found
        $alertMessage = "Pengguna tidak ditemukan!";
        $alertIcon = "error";
        $alertTitle = "Gagal Login";
        $alertText = '';

        // Menyesuaikan warna alert
        $alertBackground = 'var(--medium-dark)'; // Medium Dark untuk error
        $alertColor = 'var(--light-teal)'; // Light Teal untuk teks
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk</title>
    <link rel="stylesheet" href="../assets/styles/masuk.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        /* Apply the color palette to SweetAlert */
        :root {
            --dark: #181C14;
            --medium-dark: #3C3D37;
            --teal: #697565;
            --light-teal: #ECDFCC;
        }

        .swal2-popup {
            background-color: var(--medium-dark) !important; /* Background for the alert */
            color: var(--light-teal) !important; /* Text color */
        }

        .swal2-title {
            color: var(--light-teal) !important; /* Title color */
        }

        .swal2-icon {
            color: var(--teal) !important; /* Icon color */
        }

        .swal2-confirm {
            background-color: var(--teal) !important; /* Button color */
            color: var(--light-teal) !important; /* Button text color */
        }

        .swal2-popup.swal2-success .swal2-icon {
            border-color: var(--teal) !important;
        }

        .swal2-popup.swal2-error .swal2-icon {
            border-color: var(--medium-dark) !important;
        }
    </style>
</head>
<body>
    <div class="modal" id="loginModal">
        <div class="modal-content">
            <h2>MASUK</h2>
            <form action="masuk.php" method="POST">
                <div class="input-box">
                    <label for="email">Email</label>
                    <i class='bx bxs-user'></i>
                    <input type="email" id="email" name="email" placeholder="Masukkan Email" required>
                </div>
                <div class="input-box">
                    <label for="password">Kata Sandi</label>
                    <i class='bx bxs-lock'></i>
                    <input type="password" id="password" name="password" placeholder="Masukkan Kata Sandi" required>
                </div>
                <button type="submit" class="btn">MASUK</button>
            </form>

            <p>Belum punya akun? <a href="daftar.php">Daftar disini</a></p>
        </div>
    </div>

    <?php if ($alertMessage): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.all.min.js"></script>
    <script>
        Swal.fire({
            icon: '<?php echo $alertIcon; ?>',
            title: '<?php echo $alertTitle; ?>',
            text: '<?php echo $alertMessage; ?>',
            confirmButtonText: 'OK',
            background: '<?php echo $alertBackground; ?>',
            color: '<?php echo $alertColor; ?>',
        }).then(function() {
            <?php if ($redirectUrl): ?>
                window.location.href = '<?php echo $redirectUrl; ?>';
            <?php endif; ?>
        });
    </script>
    <?php endif; ?>
</body>
</html>
