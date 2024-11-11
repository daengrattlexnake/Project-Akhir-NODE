<?php
// Connect to the database
include '../../koneksi/db.php';

// Initialize a variable for the alert message
$alertMessage = null;
$alertType = null;
$alertTitle = null;
$alertText = null;
$redirectUrl = null;

// Check if the vehicle ID is provided
if (isset($_GET['id'])) {
    $id_kendaraan = $_GET['id'];

    // Fetch the vehicle data based on the provided ID
    $query = "SELECT * FROM kendaraan WHERE ID_kendaraan = '$id_kendaraan'";
    $result = mysqli_query($conn, $query);

    // Check if the vehicle exists
    if (mysqli_num_rows($result) > 0) {
        $vehicle = mysqli_fetch_assoc($result);
    } else {
        $alertMessage = "Data kendaraan tidak ditemukan.";
        $alertType = 'error';
        $alertTitle = 'Error!';
        $alertText = $alertMessage;
        $redirectUrl = "../mobil.php";
    }
} else {
    $alertMessage = "ID kendaraan tidak diberikan.";
    $alertType = 'error';
    $alertTitle = 'Error!';
    $alertText = $alertMessage;
    $redirectUrl = "../mobil.php";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_mobil = $_POST['nama_mobil'];
    $deskripsi_kendaraan = $_POST['deskripsi_kendaraan'];
    $gambar = $vehicle['gambar']; // Default to current image

    // Check if a new image is uploaded
    if ($_FILES['gambar']['name']) {
        $target_dir = "../../assets/uploads/";
        $target_file = $target_dir . basename($_FILES['gambar']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $valid_extensions = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($imageFileType, $valid_extensions)) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
                $gambar = $_FILES['gambar']['name'];
            } else {
                $alertMessage = "Gagal mengupload gambar baru.";
                $alertType = 'error';
                $alertTitle = 'Error!';
                $alertText = $alertMessage;
            }
        } else {
            $alertMessage = "Format gambar tidak didukung. Gunakan format JPG, JPEG, PNG, atau GIF.";
            $alertType = 'error';
            $alertTitle = 'Error!';
            $alertText = $alertMessage;
        }
    }

    // Update the vehicle data in the database
    $update_query = "UPDATE kendaraan SET nama_mobil = '$nama_mobil', deskripsi_kendaraan = '$deskripsi_kendaraan', gambar = '$gambar' WHERE ID_kendaraan = '$id_kendaraan'";
    if (mysqli_query($conn, $update_query)) {
        $alertMessage = "Data kendaraan berhasil diperbarui.";
        $alertType = 'success';
        $alertTitle = 'Berhasil!';
        $alertText = $alertMessage;
        $redirectUrl = "../mobil.php";
    } else {
        $alertMessage = "Terjadi kesalahan saat memperbarui data kendaraan.";
        $alertType = 'error';
        $alertTitle = 'Gagal!';
        $alertText = $alertMessage;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kendaraan</title>
    <link rel="stylesheet" href="../../assets/styles/mobil.css">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>
<?php include "../../assets/component/navbar_admin.php" ?>
<div class="container-edit">
    <h2>Edit Kendaraan</h2>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nama_mobil">Nama Mobil:</label>
            <input type="text" name="nama_mobil" id="nama_mobil" value="<?php echo htmlspecialchars($vehicle['nama_mobil']); ?>" required>
        </div>

        <div class="form-group">
            <label for="deskripsi_kendaraan">Deskripsi Kendaraan:</label>
            <textarea name="deskripsi_kendaraan" id="deskripsi_kendaraan" required><?php echo htmlspecialchars($vehicle['deskripsi_kendaraan']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="gambar">Gambar:</label>
            <input type="file" name="gambar" id="gambar">
            <p>Gambar saat ini:</p>
            <img src="../../assets/uploads/<?php echo htmlspecialchars($vehicle['gambar']); ?>" alt="<?php echo htmlspecialchars($vehicle['nama_mobil']); ?>" width="150px" height="auto"><br>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-edit">Simpan Perubahan</button>
            <a href="../mobil.php" class="btn-edit">Batal</a>
        </div>
    </form>
</div>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.all.min.js"></script>

<?php if ($alertMessage): ?>
    <script>
        Swal.fire({
            title: '<?php echo $alertTitle; ?>',
            text: '<?php echo $alertText; ?>',
            icon: '<?php echo $alertType; ?>',
            confirmButtonColor: '#697565',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?php echo $redirectUrl; ?>'; // Redirect to the appropriate page
            }
        });
    </script>
<?php endif; ?>

</body>
</html>
