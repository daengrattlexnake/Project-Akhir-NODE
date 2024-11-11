<?php
// Hubungkan ke database
include '../koneksi/db.php';

// Set jumlah data per halaman
$limit = 3;

// Mendapatkan halaman saat ini, jika tidak ada maka default ke halaman 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk mendapatkan data kendaraan dengan batasan halaman
$query = "SELECT * FROM kendaraan LIMIT $offset, $limit";
$result = mysqli_query($conn, $query);

// Mendapatkan total jumlah data untuk menghitung jumlah halaman
$total_query = "SELECT COUNT(*) as total FROM kendaraan";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_data = $total_row['total'];
$total_pages = ceil($total_data / $limit);

// Menambahkan pesan jika ada aksi CRUD
if (isset($_GET['message'])) {
    echo "<p>" . htmlspecialchars($_GET['message']) . "</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kendaraan</title>
    <link rel="stylesheet" href="../assets/styles/mobil.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
<!-- <?php include '../assets/component/navbar_admin.php'; ?> -->

<div class="container">
    <!-- Container untuk tombol tambah kendaraan -->
    <div class="container-btn">
        <a href="create/tambah-mobil.php" class="btn-add">Tambah Kendaraan</a>
    </div>
    
    <!-- Tabel Mobil -->
    <div class="recent-activity">
        <h2>Data Kendaraan</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Kendaraan</th>
                    <th>Nama Mobil</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop untuk menampilkan data kendaraan -->
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['ID_kendaraan'] . "</td>";
                    echo "<td>" . $row['nama_mobil'] . "</td>";
                    echo "<td>" . $row['deskripsi_kendaraan'] . "</td>";
                    echo "<td><img src='../assets/uploads/" . $row['gambar'] . "' alt='" . $row['nama_mobil'] . "' class='table-img'></td>";
                    echo "<td>
                            <a href='edit/edit_kendaraan.php?id=" . $row['ID_kendaraan'] . "' class='btn-edit'>
                                <i class='fas fa-edit'></i>
                            </a>
                            <a href='delete/hapus_kendaraan.php?id=" . $row['ID_kendaraan'] . "' class='btn-delete' onclick='deleteConfirmation(event, this.href)'>
                                <i class='fas fa-trash-alt'></i>
                            </a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>" class="pagination-btn">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" class="pagination-btn <?php echo ($i == $page) ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>" class="pagination-btn">Next</a>
        <?php endif; ?>
    </div>
</div>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.all.min.js"></script>
<script>
    // Fungsi untuk konfirmasi Hapus dengan SweetAlert2
    function deleteConfirmation(event, deleteUrl) {
        event.preventDefault();

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data ini akan dihapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--teal)',
            cancelButtonColor: 'var(--dark)',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = deleteUrl;
            }
        });
    }
</script>
</body>
</html>
