<?php
// Koneksi ke database
include '../../koneksi/db.php';

// Inisialisasi variabel error dan success
$errors = [];
$response = [
    'status' => '',
    'message' => ''
];

// Proses form submission
if (isset($_POST['submit'])) {
    // Sanitasi input
    $nama_mobil = mysqli_real_escape_string($conn, $_POST['nama_mobil']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    
    // Validasi input
    if (empty($nama_mobil)) {
        $errors[] = "Nama mobil harus diisi";
    }
    if (empty($deskripsi)) {
        $errors[] = "Deskripsi harus diisi";
    }
    
    // Validasi dan proses upload gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB
        
        $file_info = $_FILES['gambar'];
        $file_name = basename($file_info['name']);
        $file_size = $file_info['size'];
        $file_tmp = $file_info['tmp_name'];
        $file_type = $file_info['type'];
        
        // Generate unique filename
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $unique_filename = uniqid() . '.' . $file_extension;
        $target_dir = "../../assets/uploads/";
        $target_file = $target_dir . $unique_filename;
        
        // Validasi tipe file
        if (!in_array($file_type, $allowed_types)) {
            $errors[] = "Hanya file JPG, PNG, dan GIF yang diperbolehkan";
        }
        
        // Validasi ukuran file
        if ($file_size > $max_size) {
            $errors[] = "Ukuran file tidak boleh lebih dari 5MB";
        }
        
        // Validasi ekstensi file
        if (!in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $errors[] = "Format file tidak valid";
        }
        
        // Periksa apakah file adalah gambar yang valid
        $check = getimagesize($file_tmp);
        if ($check === false) {
            $errors[] = "File yang diunggah bukan gambar yang valid";
        }
    } else {
        $errors[] = "Gambar harus diunggah";
    }
    
    // Jika tidak ada error, proses penyimpanan
    if (empty($errors)) {
        try {
            // Pindahkan file
            if (!move_uploaded_file($file_tmp, $target_file)) {
                throw new Exception("Gagal mengupload gambar");
            }
            
            // Simpan ke database
            $query = "INSERT INTO kendaraan (nama_mobil, deskripsi_kendaraan, gambar) 
                     VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sss", $nama_mobil, $deskripsi, $unique_filename);
                
                if (mysqli_stmt_execute($stmt)) {
                    $response['status'] = 'success';
                    $response['message'] = "Data kendaraan berhasil ditambahkan!";
                    // Reset form
                    $nama_mobil = $deskripsi = '';
                } else {
                    throw new Exception("Error saat menyimpan ke database");
                }
                
                mysqli_stmt_close($stmt);
            } else {
                throw new Exception("Error dalam prepared statement");
            }
            
        } catch (Exception $e) {
            $response['status'] = 'error';
            $response['message'] = "Error: " . $e->getMessage();
            // Hapus file yang sudah diupload jika ada error
            if (isset($target_file) && file_exists($target_file)) {
                unlink($target_file);
            }
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = implode('<br>', $errors);
    }
    
    // Return JSON response for AJAX request
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kendaraan</title>
    <link rel="stylesheet" href="../../assets/styles/tambah-mobil.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <?php include "../../assets/component/navbar_admin.php"?>
    <div class="container">
        <div class="form-card">
            <h1>Tambah Kendaraan</h1>
            
            <form id="vehicleForm" class="vehicle-form" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama_mobil">Nama Mobil:</label>
                    <input 
                        type="text" 
                        id="nama_mobil" 
                        name="nama_mobil" 
                        class="form-input"
                        value="<?php echo isset($nama_mobil) ? htmlspecialchars($nama_mobil) : ''; ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi:</label>
                    <textarea 
                        id="deskripsi" 
                        name="deskripsi" 
                        class="form-input"
                        rows="4"
                        required
                    ><?php echo isset($deskripsi) ? htmlspecialchars($deskripsi) : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="gambar">Gambar:</label>
                    <div class="file-input-wrapper">
                        <input 
                            type="file" 
                            id="gambar" 
                            name="gambar" 
                            class="file-input"
                            accept="image/jpeg,image/png,image/gif"
                            required
                        >
                        <label for="gambar" class="file-input-label">Choose File</label>
                        <span class="file-name">No file chosen</span>
                    </div>
                    <small class="form-text text-muted">
                        Format yang diperbolehkan: JPG, PNG, GIF. Maksimal 5MB.
                    </small>
                </div>

                <button type="submit" name="submit" class="submit-btn">Tambah Kendaraan</button>
            </form>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
<script >
// Update file name display
document.querySelector('.file-input').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'No file chosen';
    e.target.parentElement.querySelector('.file-name').textContent = fileName;
});

// Handle form submission
document.getElementById('vehicleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    formData.append('submit', 'true');

    fetch(window.location.href, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                title: 'Berhasil!',
                text: data.message,
                icon: 'success',
                allowOutsideClick: false,
                allowEscapeKey: false,
                background: 'var(--light-teal)',
                color: 'var(--dark)',
                confirmButtonColor: 'var(--teal)',
                iconColor: 'var(--teal)'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../mobil.php';
                }
            });
        } else {
            Swal.fire({
                title: 'Error!',
                html: data.message,
                icon: 'error',
                background: 'var(--light-teal)',
                color: 'var(--dark)',
                confirmButtonColor: 'var(--medium-dark)',
                iconColor: 'var(--medium-dark)'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            title: 'Error!',
            text: 'Terjadi kesalahan saat memproses permintaan',
            icon: 'error',
            background: 'var(--light-teal)',
            color: 'var(--dark)',
            confirmButtonColor: 'var(--medium-dark)',
            iconColor: 'var(--medium-dark)'
        });
    });
});

</script>
</body>
</html>