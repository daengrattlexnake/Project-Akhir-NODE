<?php
include '../../koneksi/db.php';

// Mengecek apakah ID kendaraan diterima
if (isset($_GET['id'])) {
    $id_kendaraan = $_GET['id'];
    
    // Query untuk menghapus kendaraan
    $query = "DELETE FROM kendaraan WHERE ID_kendaraan = '$id_kendaraan'";
    $result = mysqli_query($conn, $query);

    // Mempersiapkan pesan SweetAlert berdasarkan hasil penghapusan
    if ($result) {
        $message = [
            'title' => 'Berhasil!',
            'text' => 'Kendaraan berhasil dihapus.',
            'icon' => 'success',
            'redirect' => '../mobil.php'
        ];
    } else {
        $message = [
            'title' => 'Gagal!',
            'text' => 'Terjadi kesalahan saat menghapus kendaraan.',
            'icon' => 'error',
            'redirect' => '../mobil.php'
        ];
    }

    // Mengirimkan pesan SweetAlert ke browser
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '{$message['title']}',
                text: '{$message['text']}',
                icon: '{$message['icon']}',
                confirmButtonColor: '#697565',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{$message['redirect']}';
                }
            });
        });
    </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Kendaraan</title>
    <link rel="stylesheet" href="../../assets/styles/mobil.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.all.min.js"></script>
</head>
<body>

</body>
</html>
